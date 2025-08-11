import api from "@/config/axios.config";
import { Button } from "primereact/button";
import { InputText } from "primereact/inputtext";
import { InputTextarea } from "primereact/inputtextarea";
import React, { useEffect, useState } from "react";
import { Task } from "./hooks/useInfiniteTasks";
import { ToggleButton } from "primereact/togglebutton";

interface TaskUpdateProps {
  onTaskUpdated?: () => void;
  task: Task;
}

const TaskUpdate: React.FC<TaskUpdateProps> = ({ onTaskUpdated, task }) => {
  const [title, setTitle] = useState(task.title);
  const [description, setDescription] = useState(task.description);
  const [isCompleted, setIsCompleted] = useState(task.is_completed ?? false);

  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await api.put(`/api/task/${task.id}`, {
        title,
        description,
        isCompleted,
      });
      setTitle("");
      setDescription("");
      setIsCompleted(false);
      onTaskUpdated?.();
    } catch (err: any) {
      setError(err.response?.data?.message || "Error modificando la tarea");
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

      <ToggleButton
        className="w-full mb-2"
        onLabel="Completada"
        offLabel="No completada"
        checked={isCompleted}
        onChange={(e) => setIsCompleted(e.value)}
      />

      <Button
        type="submit"
        disabled={loading}
      >
        {loading ? "Actualizando..." : "Actualizar Tarea"}
      </Button>
    </form>
  );
};

export default TaskUpdate;
