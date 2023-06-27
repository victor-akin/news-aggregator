'use client';
import { useEffect, useState } from "react";
import Header from "../components/Header"
import { getUser } from "../utils/fetch-functions";
import { useRouter } from "next/navigation";
import IsAuthenticated from "../components/IsAuthenticated";

export default function DashboardLayout({
  children
}: {
  children: React.ReactNode
}) {
  const router = useRouter();

  const [user, setUser] = useState({ name: false })

  useEffect(() => {
    const isAuthenticated = async () => {
      const [user, error] = await getUser()

      console.log(user);
      if (error) return router.push('/');

      setUser(user)
    }

    isAuthenticated()
  }, [router])


  return (
    <section className="bg-white lg:px-40 md:px-20">
      <IsAuthenticated isAuthenticated={user.name}>
        <Header />
        {children}
      </IsAuthenticated>
    </section>
  )
}