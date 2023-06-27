'use client';
import Search from "@/app/components/Search";
import NewsList from "../../components/NewsList";
import { useEffect, useState } from "react";
import { getUserNewsFeed, searchForArticles } from "@/app/utils/fetch-functions";

export type SearchQuery = {
  search_term: string;
  date: string;
  category: string;
  source: string;
}

export default function Articles() {
  console.log('rendering');

  const initSearchQuery: SearchQuery = {} as SearchQuery;
  const [searchQuery, updateSearchQuery] = useState<SearchQuery>(initSearchQuery)
  const [articles, updateArticles] = useState([]);
  const [error, updateError] = useState(false);


  useEffect(() => {

    async function getNewsFeed() {
      const [res, err] = await getUserNewsFeed()

      if (!err) {
        updateArticles(res)
      }
    }

    getNewsFeed()
  }, [])

  const search = async (e: SubmitEvent) => {
    e.preventDefault()

    const [res, err] = await searchForArticles(searchQuery);

    if (err) {
      updateError(true)
      return;
    }

    updateArticles(res)
  }

  return (
    <section className="my-12">
      <div className="">
        <Search searchQuery={searchQuery} onUpdateSearchQuery={updateSearchQuery} onSearch={search} />
      </div>
      <div className="pt-16">
        <ul role="list" className="divide-y divide-gray-300">
          {articles.map((article, k) => (<NewsList article={article} key={k} />))}
        </ul>
      </div>
    </section>
  )
}
