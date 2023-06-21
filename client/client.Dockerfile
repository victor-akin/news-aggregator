FROM node:20-alpine

RUN mkdir -p /usr/src

WORKDIR /usr/src

COPY . .

EXPOSE 3000

CMD npm run dev