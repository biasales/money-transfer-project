# Money Transfers API

Bem-vindo à API de Gestão de Usuários e Transferência de Dinheiro! Esta API foi projetada para permitir a criação e gerenciamento de usuários, bem como a realização de transferências de dinheiro entre eles.

## Como Usar

### 1. Criação de Usuários

#### Endpoint: `api/users`

- **Método**: POST
- **Descrição**: Cria um novo usuário.

##### Parâmetros da Requisição:

- `name` (string): Nome do usuário.
- `email` (string): Endereço de e-mail único associado ao usuário.
- `type` (int): Tipo de usuário (1 -> comum, 2 -> lojista)
- `document` (string): número de documento único associado ao usuário.
- `senha` (string): Senha para autenticação.
- `amount` (string): Valor na carteira do usuário.

docker-compose exec php-fpm bash && vendor/bin/phinx migrate

##### Exemplo de Requisição:

```json
{
  "name": "John Doe",
  "email": "john.doe@ee.com",
  "type": "1",
  "document": "125454546",
  "password": "12443456",
  "amount": "20.00"
}
```

##### Resposta de Sucesso:

- **Status Code 201**
```json
{
  "message": "User successfully created with id 123"
}
```

##### Resposta de Falha:
- **Status Code 200**
```json
{
  "message": "Unable to create user user"
}
```

### 2. Visualização de Dados do Usuário

#### Endpoint: `/api/users`

- **Método**: GET
- **Descrição**: Retorna os dados de um usuário específico.

##### Parâmetros da Requisição:

- `id` (int): ID do usuário desejado.

##### Exemplo de Requisição:

```json
{
  "id": "123"
}
```

##### Resposta de Sucesso:

```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "type": "john.doe@example.com",
  "document": "123456",
  "senha": "123456",
  "amount": "20.00"
}
```

##### Resposta de Falha:
- **Status Code 200**
```json
{
  "message": "Unable to find user"
}
```

### 3. Deleção de Usuário

#### Endpoint: `/api/users/`

- **Método**: DELETE
- **Descrição**: Deleta um usuário específico.

##### Parâmetros da Requisição:

- `id` (int): ID do usuário a ser deletado.

##### Exemplo de Requisição:

```json
{
  "id": "123"
}
```

##### Resposta de Sucesso:

```json
{
  "message": "Deleted user with id: 123"
}
```

##### Resposta de Falha:
- **Status Code 200**
```json
{
  "message": "Unable to delete user"
}
```

### 4. Criação de Transação

#### Endpoint: `/api/transaction`

- **Método**: POST
- **Descrição**: Cria uma nova transação financeira.

##### Parâmetros da Requisição:

- `payer_id` (int): ID do usuário que vai transferir dinheiro.
- `payee_id` (int): ID do usuário que vai receber dinheiro.
- `amount` (string): Valor da transação.

##### Exemplo de Requisição:

```json
{
  "payer_id": 123,
  "payee_id": 456,
  "amount": "100.00"
}
```

##### Resposta de Sucesso:

```json
{
  "mensagem": "Transaction created successfully with id: 123"
}
```

##### Resposta de Falha:
- **Status Code 200**
```json
{
  "message": "Failed to create transaction"
}
```

### 5. Transferência de Dinheiro

#### Endpoint: `/api/transaction/execute`

- **Método**: GET
- **Descrição**: Realiza uma transferência de dinheiro entre usuários.

##### Parâmetros da Requisição:

- `payer_id` (int): ID do usuário que vai transferir dinheiro.
- `payee_id` (int): ID do usuário que vai receber dinheiro.
- `amount` (string): Valor da transação.

##### Exemplo de Requisição:

```json
{
  "payer_id": 123,
  "payee_id": 456,
  "amount": "100.00"
}
```

### 6. Visualização de Transações

#### Endpoint: `/api/transaction`

- **Método**: GET
- **Descrição**: Retorna uma transação

##### Parâmetros da Requisição:

- `usuario_id` (int): ID da transferencia 

##### Exemplo de Requisição:

```json
{
  "id": "123"
}
```

##### Resposta de Sucesso:

```json
{
  "payer_id": 123,
  "payee_id": 456,
  "amount": "100.00"
}
```

##### Resposta de Falha:
- **Status Code 200**
```json
{
  "mensagem": "Failed to find transaction."
}
```

## Erros Comuns

- **400 Bad Request**: Requisição inválida.
- **404 Not Found**: Recurso não encontrado.
- **500 Internal Server Error**: Erro interno do servidor.

## Sugestões

Fique a vontade para novas sugestões para a MoneyTransferAPI 😊