'use client';
import { addUserInterests, deleteUserInterests, getAllInterests, getUserInterests } from "@/app/utils/fetch-functions";
import { useEffect, useState } from "react";

export default function Profile() {
  const [interests, updateInterests] = useState({});
  const [userInterests, updateUserInterests] = useState([])

  useEffect(() => {

    async function setupInterests() {

      const [allInterests, err] = await getAllInterests();

      if (err) return;

      const [existingUserInterests, error] = await getUserInterests()

      if (error) return;

      updateInterests(allInterests)
      updateUserInterests(existingUserInterests)
    }

    setupInterests()

  }, [])

  const addToUserInterest = async (e: any, superGroupName: string, subGroupId: number) => {
    const [res, err] = await addUserInterests(superGroupName, subGroupId)

    if (!err) {
      updateUserInterests([...userInterests, res] as any);
    }
  }

  const removeFromUserInterest = async (e: any, interesId: number) => {
    const [res, err] = await deleteUserInterests(interesId)

    if (!err) {
      updateUserInterests(userInterests.filter((interest: any) => interesId !== interest.id))
    }
  }

  return (
    <div className="text-slate-500 mt-20 p-5">
      <div>
        <div>
          <p className="my-5">Remove what you are no longer interested in</p>
          {
            userInterests.map((interest: any, i) => {
              return (
                <button
                  key={i}
                  className="rounded-full bg-rose-500 text-white p-2 m-2"
                  onClick={(e) => removeFromUserInterest(e, interest.id)}
                >
                  {interest.parent_interest.name}
                </button>
              )
            })
          }

        </div>
        <div className="mt-20">
          <p className="my-6">Add something new you are interested in</p>
          {
            Object.keys(interests).map((key: any) => {

              return (interests as Array<any>)[key].map((subInterest: any) => {
                return (
                  <button
                    key={`${subInterest.name}_${key}`}
                    className="rounded-full bg-emerald-500 text-white p-2 m-2"
                    onClick={(e) => addToUserInterest(e, key, subInterest.id)}
                  >
                    {subInterest.name}
                  </button>
                )
              })
            })
          }
        </div>
      </div>
    </div >
  )
}
