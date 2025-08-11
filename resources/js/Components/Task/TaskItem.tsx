import { FC, useRef, useState } from "react";
import { Task } from "./hooks/useInfiniteTasks";
import { Card } from "primereact/card";
import { Button } from "primereact/button";
import { Dialog } from "primereact/dialog";
import TaskUpdate from "./TaskUpdate";
import { ConfirmDialog, confirmDialog } from 'primereact/confirmdialog';
import { Toast } from 'primereact/toast';
import api from "@/config/axios.config";

interface TaskItemProps {
  task: Task;
}

const TaskItem: FC<TaskItemProps> = ({ task }) => {
  const [visible, setVisible] = useState(false);

  const onTaskUpdated = () => window.location.reload();

  const toast = useRef<Toast>(null);

  const accept = async () => {
    toast.current?.show({ severity: 'info', summary: 'Confirmado' });

    try {
      await api.delete(`/api/task/${task.id}`);
      
      window.location.reload();
    } catch (err: any) {
    } finally {
    }
  }

  const reject = () => {
    toast.current?.show({ severity: 'warn', summary: 'Rechazado' });
  }

  const confirmDelete = () => {
    confirmDialog({
      message: '¿Quieres borrar este registro?',
      header: 'Confirmación',
      defaultFocus: 'reject',
      accept,
      reject
    });
  };

  return (
    <Card className="w-full flex flex-col gap-2">
      <h3 className="font-bold">{task.title}</h3>
      <p className="text-gray-600">{task.description}</p>

      <div className="flex gap-2 mt-2 justify-end">
        <Button label="Editar" className="mb-2" size="small" severity="warning" onClick={() => setVisible(true)}/>
        <Dialog
          header="Modificar tarea"
          visible={visible}
          onHide={() => {if (!visible) return; setVisible(false); }}
          style={{ width: '50vw' }} breakpoints={{ '960px': '75vw', '641px': '100vw' }}
        >
          <TaskUpdate onTaskUpdated={onTaskUpdated} task={task}/>
        </Dialog>

        <Toast ref={toast} />
        <ConfirmDialog />
        <Button label="Eliminar" className="mb-2" size="small" severity="danger" onClick={confirmDelete}/>
      </div>
    </Card>
  );
};

export default TaskItem;
