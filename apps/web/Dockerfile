FROM node:20-alpine
WORKDIR /app


# copy package files first for better caching
COPY package*.json ./
COPY pnpm-lock.yaml* yarn.lock* ./


RUN npm ci --silent


COPY . /app


EXPOSE 5173
CMD ["npm", "run", "dev"]