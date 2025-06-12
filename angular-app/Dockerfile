FROM node:20-slim

# Diretório de trabalho dentro do container
WORKDIR /usr/src/app

# Copia somente os arquivos de dependência
COPY package*.json ./
COPY .env.example ./.env

# Instala dependências
RUN npm install

# Copia todo o código fonte
COPY . .

# Instala Angular CLI globalmente (se precisar)
RUN npm install -g @angular/cli

# Expõe porta do Angular
EXPOSE 4200

# Comando para iniciar o servidor Angular, ouvindo em todas interfaces
CMD ["npm", "run", "start", "--", "--host", "0.0.0.0"]



