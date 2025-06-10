# # Usa uma versão compatível do Node.js
# FROM node:20.19-alpine

# # Define o diretório de trabalho dentro do contêiner
# WORKDIR /usr/src/app

# # Copia os arquivos do projeto para o contêiner
# COPY package*.json ./

# # Instala as dependências do projeto
# RUN npm install

# # Copia o restante dos arquivos
# COPY . .

# # Define o comando padrão para iniciar o Angular
# CMD ["npm", "start"]

# # Exponde a porta usada pelo Angular
# EXPOSE 4200



# Imagem base mais compatível com bibliotecas nativas
FROM node:20-slim

# Define o diretório de trabalho dentro do contêiner
WORKDIR /usr/src/app

# Copia os arquivos do projeto para o contêiner
COPY package*.json ./
COPY .env.example ./.env

# Instala as dependências com segurança (evita erros de musl)
RUN rm -rf node_modules package-lock.json && \
    npm install

# Copia o restante dos arquivos
COPY . .

# Expõe a porta padrão do Angular
EXPOSE 4200

# Comando para iniciar o Angular
CMD ["npm", "run", "start", "--", "--host", "0.0.0.0"]




# # Etapa 1: build da aplicação
# FROM node:20-alpine AS builder

# WORKDIR /usr/src/ap

# # Copia os arquivos necessários
# COPY package*.json ./
# RUN npm install

# COPY . .

# # Gera o build de desenvolvimento (opcional)
# # RUN npm run build

# # Etapa 2: container de desenvolvimento
# FROM node:20-alpine

# WORKDIR /usr/src/app

# # Copia os arquivos instalados e o projeto
# COPY --from=builder /app /app

# EXPOSE 4200

# # Executa o Angular com host 0.0.0.0
# CMD ["npm", "run", "start", "--", "--host", "0.0.0.0"]


