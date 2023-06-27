'use client';
import { FormEvent, useState } from "react";
import { getLatestNews, login, register } from "../utils/fetch-functions";
import { useRouter } from 'next/navigation'

type LoginSignupState = {
  isLogin: boolean;
  username: string;
  password: string;
  email: string;
  errorMessage: string;
  successMessage: string;
}

export default function LoginSignup() {

  const router = useRouter();
  const initState: LoginSignupState = {
    isLogin: true
  } as LoginSignupState
  const [state, updateState] = useState<LoginSignupState>(initState)

  const submitForm = async (e: FormEvent) => {
    e.preventDefault();
    updateHelper('errorMessage', '')
    updateHelper('successMessage', '')

    let [res, error] = state.isLogin ?
      await login(state.email, state.password) :
      await register(state.email, state.password, state.username);

    if (error) {
      updateHelper('errorMessage', res.data.message)
      return;
    }

    if (state.isLogin) return router.push('auth/articles')

    if (!state.isLogin) await getLatestNews()

    updateHelper('successMessage', res.message)
  }

  const updateHelper = (key: string, value: any) => {
    const data = { [key]: value }
    updateState(prev => ({ ...prev, ...data }))
  }

  return (
    <div className="flex-col w-full sm:px-40 md:py-5">
      <div>
        <p className="font-serif text-red-200">{state.errorMessage}</p>
        <p className="font-serif text-emerald-700">{state.successMessage}</p>
        <form className="space-y-6" action="#" method="POST" onSubmit={(e) => submitForm(e)}>
          <div>
            <label htmlFor="email" className="block text-sm font-medium leading-6 text-gray-900">
              Email address
            </label>
            <div className="mt-2">
              <input
                id="email"
                name="email"
                type="email"
                autoComplete="email"
                placeholder="email"
                value={state.email}
                onChange={(e) => updateHelper('email', e.target.value)}
                required
                className="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>

          <div className={state.isLogin ? "hidden" : ""}>
            <label htmlFor="email" className="block text-sm font-medium leading-6 text-gray-900">
              Username
            </label>
            <div className="mt-2">
              <input
                id="username"
                name="username"
                type="text"
                autoComplete="username"
                placeholder="username"
                value={state.username}
                onChange={(e) => updateHelper('username', e.target.value)}
                className="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>

          <div>
            <div className="flex items-center justify-between">
              <label htmlFor="password" className="block text-sm font-medium leading-6 text-gray-900">
                Password
              </label>
            </div>
            <div className="mt-2">
              <input
                id="password"
                name="password"
                type="password"
                autoComplete="current-password"
                placeholder="password"
                value={state.password}
                onChange={(e) => updateHelper('password', e.target.value)}
                required
                className="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>

          <div>
            <button
              type="submit"
              className="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
      <div className="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
        <a
          onClick={() => updateHelper('isLogin', !state.isLogin)}
          href="#"
          className="rounded-md bg-slate-900 text-white hover:text-black px-3.5 py-2.5 text-sm font-semibold shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
        >
          Login
        </a>
        <a onClick={() => updateHelper('isLogin', !state.isLogin)} href="#" className="text-sm font-semibold leading-6 text-white">
          Signup <span aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  )
}