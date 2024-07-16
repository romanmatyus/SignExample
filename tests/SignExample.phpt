<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$signExample = new SignExample('assets/ec-secp256k1-priv-key.pem', 'assets/ec-secp256k1-pub-key.pem');
Assert::type(SignExample::class, $signExample); 

$data = 'Hello World!';

Assert::equal('ff7a3f68b1daa197a5dfe4bfd15f989e89795da161c7b4401eeab884ce4e1cde', $signExample->getSign($data));
Assert::type('string', $signExample->getEcdsa($data . $signExample->getSign($data)));

Assert::true($signExample->verified($data, $signExample->getSign($data), $signExample->getEcdsa($data . $signExample->getSign($data))));
Assert::false($signExample->verified($data, $signExample->getSign($data) . '--', $signExample->getEcdsa($data . $signExample->getSign($data))));
