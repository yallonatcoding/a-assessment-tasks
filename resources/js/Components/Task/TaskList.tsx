import React, { useEffect, useRef } from "react";
import TaskItem from "./TaskItem";
import { useInfiniteTasks } from "./hooks/useInfiniteTasks";

interface TasksListProps {
  filters?: Record<string, any>;
}

const TaskList: React.FC<TasksListProps> = ({ filters = {} }) => {
  const { tasks, fetchTasks, hasMore, loading } = useInfiniteTasks(filters);
  const observer = useRef<IntersectionObserver | null>(null);
  const lastTaskRef = useRef<HTMLDivElement | null>(null);

  useEffect(() => {
    fetchTasks();
  }, [filters]);

  useEffect(() => {
    if (loading) return;
    if (observer.current) observer.current.disconnect();

    observer.current = new IntersectionObserver(
      (entries) => {
        if (entries[0].isIntersecting && hasMore) {
          fetchTasks();
        }
      },
      { threshold: 1.0 }
    );

    if (lastTaskRef.current) {
      observer.current.observe(lastTaskRef.current);
    }
  }, [loading, hasMore, fetchTasks]);

  return (
    <div className="flex flex-col gap-2">
      {tasks.map((task, index) => {
        const isLast = index === tasks.length - 1;
        return (
          <div
            key={task.id}
            ref={isLast ? lastTaskRef : null}
          >
            <TaskItem task={task} />
          </div>
        );
      })}

      {loading && <p className="text-center p-4">Cargando...</p>}
      {!hasMore && <p className="text-center p-4">No hay más tareas</p>}
    </div>
  );
};

export default TaskList;
