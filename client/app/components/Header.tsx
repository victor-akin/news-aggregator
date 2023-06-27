'use client';
import Link from 'next/link';
import { logout } from '../utils/fetch-functions';
import { useRouter } from 'next/navigation';

export default function Header() {
  const router = useRouter()

  const logoutUser = async () => {
    const [res, err] = await logout();

    if (!err) return router.push('/')

  }
  return (
    <header className="bg-white">
      <nav
        className="flex md:items-center pt-6 pl-5 pr-3 sm:px-6 justify-between sm:items-center"
        aria-label="Global"
      >
        <div className="">
          <Link href="/auth/profile" className="mr-10 text-xl font-semibold leading-6 text-gray-900">
            Settings
          </Link>
          <Link href="/auth/articles" className="text-xl font-semibold leading-6 text-gray-900">
            News Feed
          </Link>
        </div>
        <div className="">
          <Link href="#" className="text-sm font-semibold leading-6 text-gray-900" onClick={logoutUser}>Logout</Link>
        </div>
      </nav>
    </header>
  )
}
