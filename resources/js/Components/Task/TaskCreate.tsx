import api from "@/config/axios.config";
import { Button } from "primereact/button";
import { InputText } from "primereact/inputtext";
import { InputTextarea } from "primereact/inputtextarea";
import React, { useState } from "react";

interface TaskCreateProps {
  onTaskCreated?: () => void;
}

const TaskCreate: React.FC<TaskCreateProps> = ({ onTaskCreated }) => {
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await api.post("/api/task", {
        title,
        description,
      });
      setTitle("");
      setDescription("");
      onTaskCreated?.();
    } catch (err: any) {
      setError(err.response?.data?.message || "Error creando la tarea");
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="mb-6">
      {error && <p className="text-red-500 mb-2">{error}</p>}

      <InputText
        type="text"
        placeholder="Título"
        className="border rounded px-3 py-2 w-full mb-2"
        value={title}
        onChange={(e) => setTitle(e.target.value)}
        required
      />

      <InputTextarea
        placeholder="Descripción (opcional)"
        className="border rounded px-3 py-2 w-full mb-2"
        value={description}
        onChange={(e) => setDescription(e.target.value)}
      />

      <Button
        type="submit"
        disabled={loading}
      >
        {loading ? "Creando..." : "Crear Tarea"}
      </Button>
    </form>
  );
};

export default TaskCreate;
