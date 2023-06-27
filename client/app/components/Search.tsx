'use client';

import { SearchQuery } from "../auth/articles/page";

export default function Search({
  searchQuery,
  onUpdateSearchQuery,
  onSearch
}: {
  searchQuery: SearchQuery,
  onUpdateSearchQuery: Function,
  onSearch: Function
}) {

  const updateSearchQuery = (e: any, key: string) => {
    e.stopPropagation();
    const data = { [key]: e.target.value }
    onUpdateSearchQuery((prev: SearchQuery) => ({ ...prev, ...data }))
  }

  return (
    <section className="px-6">
      <form
        action="#"
        method="post"
        className="flex md:flex-row flex-wrap justify-between text-slate-500 rounded shadow-sm"
        onSubmit={(e) => onSearch(e)}
      >
        <div className="md:basis-1/5 sm:basis-1/3 mb-10 md:mb-0">
          <input
            type="text"
            id="search"
            name="search"
            value={searchQuery.search_term ?? ""}
            required
            className="w-full focus:outline-none"
            placeholder="search..."
            onChange={(e) => updateSearchQuery(e, 'search_term')}
          />
        </div>
        <div className="basis-1/5">
          <input
            type="date"
            id="date"
            name="date"
            value={searchQuery.date ?? ""}
            onChange={(e) => updateSearchQuery(e, 'date')}
            className="w-full focus:outline-none text-sm pr-10"
          />
        </div>
        <div className="basis-1/5 mb-10 lg:mb-0">
          <select
            id="category"
            name="category"
            value={searchQuery.category ?? ""}
            onChange={(e) => updateSearchQuery(e, 'category')}
            className="focus:outline-none text-sm"
          >
            <option>Category</option>
            <option>Science</option>
            <option>Politics</option>
          </select>
        </div>
        <div className="basis-1/5">
          <select
            id="source"
            name="source"
            value={searchQuery.source ?? ""}
            onChange={(e) => updateSearchQuery(e, 'source')}
            className="focus:outline-none text-sm"
          >
            <option>Source</option>
            <option>Science</option>
            <option>Politics</option>
          </select>
        </div>
        <div className="basis-1/5 lg:mt-5 xl:mt-0 flex justify-center sm:mt-20">
          <button
            type="submit"
            className="justify-center rounded-md bg-gray-800 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
          >
            Search
          </button>
        </div>
      </form>
    </section>
  )
}