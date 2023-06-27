import { AxiosError } from "axios";
import axios from "./axios";
import { SearchQuery } from "../auth/articles/page";

export const csrf = () => makeRequest(() => axios.get('sanctum/csrf-cookie'))

export const login = async (email: string, password: string) => {
  await csrf()
  return makeRequest(() => axios.post('auth/login', { email, password }));
}

export const register = async (email: string, password: string, username: string) => {
  await csrf()
  return makeRequest(() => axios.post('auth/register', { email, password , username}));
}

export const getUser = () => makeRequest(() => axios.get('api/user'));

export const getUserNewsFeed = (from = 0) => makeRequest(() => axios.get('api/user/profile/news-feed', { params: from }));

export const searchForArticles = (data: SearchQuery) => makeRequest(() => axios.get('api/search', { params: data }));

export const getArticle = (hash: string) => makeRequest(() => axios.get('api/article', { params: { hash } }));

export const logout = () => makeRequest(() => axios.post('auth/logout'));

export const getAllInterests = () => makeRequest(() => axios.get('api/category'));

export const getUserInterests = () => makeRequest(() => axios.get('api/user/profile/interests'));

export const deleteUserInterests = (id: number) => makeRequest(() => axios.delete(`api/user/profile/interests/${id}`));

export const getLatestNews = () => makeRequest(() => axios.get('api/news/latest'));

export const addUserInterests = (groupName: string, groupId: number) => (
  makeRequest(() => axios.post('api/user/profile/interests', {
    group_name: groupName, group_id: groupId
  }))
)

async function makeRequest(callable: Function) {
  try {
    let res = await callable();
    return [res.data, false];
  } catch (error) {
    const err = error as AxiosError;
    return [err.response, true];
  }
}