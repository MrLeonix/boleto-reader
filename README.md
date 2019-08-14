# Boleto Reader

PHP Project for getting information from a _boleto_, such as:
- Bank
- Coin
- Due date
- Number
- Value

## Installation

Use [Composer](https://getcomposer.org/) to install `boleto-reader`.

```bash
composer require mrleonix/boleto-reader
```

## Usage

The `create` function returns a `Boleto` instance.

```php
$boletoNumber = '34190.00000 00000.000003 41000.000000 0 44442000005025'; // Bank boleto type
$boleto = Boleto::create($boletoNumber);

$boletoNumber = '84670000001-7 43590024020-9 02405000243-5 84221010811-9'; // Dealership boleto type
$boletoTwo = Boleto::create($boletoNumber);
```

Then you can access `Boleto` information as following:

```php
// Getters only !

$boleto->bank // @return Bank
$boleto->bank->code // @return string
$boleto->bank->name // @return string
$boleto->coin // @return Coin
$boleto->coin->code // @return string
$boleto->coin->name // @return string
$boleto->dueDate // @return Carbon
$boleto->number // @return string
$boleto->type // @return string
$boleto->value // @return float
```

**Note:** `Dealership` boletos do not have `bank`, `coin` and `dueDate` properties.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)