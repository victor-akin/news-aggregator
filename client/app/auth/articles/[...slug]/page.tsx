'use client'

import Link from "next/link";
import { getArticle } from "../../../utils/fetch-functions"
import { useEffect, useState } from "react";

type Article = {
  article: string;
  article_url: string;
  author: string;
  category: string;
  date: string;
  description: string
  image_url: string;
  source: string;
  title: string
}

export default function DisplayArticle({ params }: { params: { slug: string } }) {

  let initArticle: Article = {
    article: '',
    article_url: '',
    author: '',
    category: '',
    date: '',
    description: '',
    image_url: '',
    source: '',
    title: '',
  }

  const [article, updateArticle] = useState<Article>(initArticle);

  useEffect(() => {
    async function fetchArticle() {
      const [res, err] = await getArticle(params.slug);

      console.log('res', res);
      console.log('err', err);

      if (!err) updateArticle(res.formatted_article)
    }

    fetchArticle()
  }, [params.slug])

  return (
    <section className="text-slate-500 mt-20 p-5">
      <p className="my-5 font-semibold">{article?.title}</p>
      <img
        className="w-full h-full object-contain"
        src={article?.image_url}
      />

      <p className="mt-10 leading-loose text-xl">{article?.article}</p>
      <p className="mt-10"><Link href={article?.article_url as string}>Visit Source</Link></p>
    </section>
  )
}
