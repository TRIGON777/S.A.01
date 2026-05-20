# Street Legends Store V2

Projeto em PHP + JavaScript + MySQL com:

- loja virtual Street Legends em tons de marrom
- login e cadastro
- carrinho
- checkout protegido por login
- pagamento simulado por cartão e Pix
- desconto automático de 10% acima de R$ 300
- barra de pesquisa estilo Google com sugestões automáticas
- filtro por categoria
- banco MySQL criado automaticamente

## Como rodar no XAMPP

1. Coloque a pasta `street_legends_store_v2` dentro de `C:\xampp\htdocs\`.
2. Abra o XAMPP.
3. Ligue Apache e MySQL.
4. Acesse:

```txt
http://localhost/street_legends_store_v2/
```

Se seu Apache estiver na porta 9999:

```txt
http://localhost:9999/street_legends_store_v2/
```

## Banco de dados

No arquivo `includes/config.php`, ajuste a senha se precisar:

```php
define('DB_USER', 'root');
define('DB_PASS', 'root');
```

## Imagens

Coloque suas imagens em:

```txt
assets/img/
```

No código existem comentários mostrando onde trocar banner e produtos.
