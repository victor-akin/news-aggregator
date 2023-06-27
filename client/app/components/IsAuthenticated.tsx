export default function IsAuthenticated({
  isAuthenticated,
  children
}: {
  isAuthenticated: boolean,
  children: React.ReactNode
}) {

  if (isAuthenticated) return <>{children}</>
  return <></>

}
