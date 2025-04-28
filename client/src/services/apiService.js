import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/tasks";

const getAuthHeaders = () => ({
  headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
});

export const fetchTasks = (userId) =>
  axios.post(`${API_URL}/fetch`, { user_id: userId }, getAuthHeaders());

export const addTask = (title, description, userId) =>
  axios.post(API_URL, { title, description, user_id: userId }, getAuthHeaders()); 

export const toggleTask = (taskId) =>
  axios.put(`${API_URL}/toggle/${taskId}`, {}, getAuthHeaders());

export const updateTask = (taskId, title, description) =>
  axios.put(`${API_URL}/${taskId}`, { title, description }, getAuthHeaders()); 

export const deleteTask = (taskId) =>
  axios.delete(`${API_URL}/${taskId}`, getAuthHeaders());
