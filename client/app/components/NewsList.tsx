import Link from 'next/link';

export default function NewsList({ article }: { article: any }) {
  return (
    <Link href={`/auth/articles/${article.fingerprint}`} className="mr-10 text-xl font-semibold leading-6 text-gray-900">
      <li key={article.fingerprint} className="flex justify-between gap-x-6 py-5 px-5">
        <div className="flex gap-x-4">
          <div className="min-w-0 flex-auto">
            <p className="text-sm font-semibold leading-6 text-gray-900">{article.formatted_article.title}</p>
            <p className="mt-1 text-xs leading-5 text-gray-500">{article.formatted_article.description}</p>
          </div>
        </div>
      </li>
    </Link>
  )
}
