FROM node:14-alpine

WORKDIR /app/front

COPY ./front /app/front/

RUN npm install