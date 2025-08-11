import api from "@/config/axios.config";
import { useState, useCallback } from "react";

export type Task = {
  id: number,
  title: string,
  description: string,
  is_completed: boolean,
}

export type Data = {
  items: Task[] | [],
  total: number,
  done: boolean,
  page: number,
  perPage: number,
};

type TasksResponse = {
  data: Data,
  message: string,
  success: boolean,
}

export const useInfiniteTasks = (filters: Record<string, any> = {}) => {
  const [tasks, setTasks] = useState<Task[]>([]);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);
  const [loading, setLoading] = useState(false);

  const fetchTasks = useCallback(async () => {
    if (loading || !hasMore) return;
    setLoading(true);

    try {
      const {data} = await api.get<TasksResponse>("/api/tasks", {
        params: {
          page,
          per_page: 5,
          ...filters,
        },
      });

      setTasks((prev) => [...prev, ...data.data.items]);
      setHasMore(!data.data.done);
      setPage((prev) => prev + 1);
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  }, [page, filters, loading, hasMore]);

  return { tasks, fetchTasks, hasMore, loading };
};
