import { useState, FC } from "react";
import TaskList from "./TaskList";
import { Button } from "primereact/button";
import TaskCreate from "./TaskCreate";
import { Dialog } from "primereact/dialog";

const TasksView: FC = () => {
  const [filters, setFilters] = useState({ search: "" });
  const [visible, setVisible] = useState(false);

  const onTaskCreated = () => window.location.reload();

  return (
    <div className="mx-auto">
      <Button label="Crear nueva tarea" className="mb-2" onClick={() => setVisible(true)}/>
				
      <Dialog
				header="Nueva tarea"
				visible={visible}
				onHide={() => {if (!visible) return; setVisible(false); }}
				style={{ width: '50vw' }} breakpoints={{ '960px': '75vw', '641px': '100vw' }}
			>
				<TaskCreate onTaskCreated={onTaskCreated}/>
			</Dialog>
      
      <TaskList filters={filters}/>
    </div>
  );
};

export default TasksView;
