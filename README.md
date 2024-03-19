# 2024LLED
## Resumo Técnico
Este projeto tem como objetivo simular o comportamento de um software de apostas e sorteios, utilizando para criação da interface gráfica HTML e CSS, JavaScript para o Front-end, PHP para o Back-end e MySQL como Banco de Dados. 

## Funcionalidades
Para tentar criar uma simulação mais realista, optou-se pelo uso de uma tela de login. Esta tela possui como credenciais o CPF, que será único para cada usuário, e uma senha criptografada, além disso a tela conta com um botão entrar no sistema e um para se registrar.
![login](https://github.com/ArthurZL/2024LLED/assets/71044771/c5818372-98a4-4123-b41e-cffdc43e5a86)

Ao clicar no botão de registro, o usuário será levado para a tela de cadastro, nela será preciso fornecer seu CPF, nome, senha e a confirmação da senha.
![signup](https://github.com/ArthurZL/2024LLED/assets/71044771/92cb855e-b026-488e-982c-665e73e4359c)

Caso qualquer um destes campos for deixado em branco ou se a confirmação da senha for distinta da senha, uma mensagem de erro aparecerá e impedirá o cadastro.
![signup-error1](https://github.com/ArthurZL/2024LLED/assets/71044771/68158b55-2358-491c-aa39-34333e727500)
![signup-error2](https://github.com/ArthurZL/2024LLED/assets/71044771/7af5789c-53df-40bf-9e61-0cbccbdf829f)

Ao iniciar a tela de login pelo primeira vez será criado a primeira edição do sorteio e um usuário administrador, para entrar nesta conta baste inserir o CPF **00000000000** e a senha **senhaformeadmin**, isso lhe levará para a tela administrativa, onde pode-se visualizar todas as apostas feitas para a edição atual do sorteio ou realizar o sorteio da edição atual.
![home](https://github.com/ArthurZL/2024LLED/assets/71044771/5c28026f-a6ac-46c1-a691-ed2dd16d7046)

Caso opte de visualizar as postas registradas até o momento, o usuário será levado para uma tabela contendo todas as informações pessoais dos apostadores, bem como os dados de suas apostas. Essas informações também podem ser vistas pelo console através da tecla *F12*.
![show](https://github.com/ArthurZL/2024LLED/assets/71044771/42a81844-5e77-4202-a2c1-704043f04302)
![show-console](https://github.com/ArthurZL/2024LLED/assets/71044771/23cfdd98-f6d8-4ff6-bac6-ec6f170d6240)

Quando o administrador clicar no botão de sorteio será exibida a tela de resultados, contendo informações de **Número de Sorteios Extras**, **Número de Ganhadores**, **Números Sorteados**, **Dados Pessoas dos Vencedores** e **Estatística das Apostas**, este também pode ser visto pelo console.
![raffle](https://github.com/ArthurZL/2024LLED/assets/71044771/3294f879-b077-40cd-afad-b3d2ee87af86)
![raffle-console](https://github.com/ArthurZL/2024LLED/assets/71044771/5c99ebac-2abd-4539-9e45-78ace1c86193)

Caso o usuário seja um apostador, logo após realizar o login ele será redirecionado para a tela de apostas, nesta há cinco campos para inserir os números desejados para o sorteio, o botão **S** que gera cinco números aleatórios para o usuário e um botão para confirmar a aposta.
![bet](https://github.com/ArthurZL/2024LLED/assets/71044771/1d45c7dd-603c-460e-b3ed-9e05da60a34c)

O apostador será impedido de realizar a confirmação caso a quantidade de números não esteja adequada ou se valores estiverem fora do intervalo permitido.
![bet-error1](https://github.com/ArthurZL/2024LLED/assets/71044771/dbd3e928-5399-45b7-8ba9-edb4d085c77d)
![bet-error2](https://github.com/ArthurZL/2024LLED/assets/71044771/0efb6f47-a3d8-4e97-9807-0a63bb494b25)
![bet-validate1](https://github.com/ArthurZL/2024LLED/assets/71044771/c001e261-5737-42ff-b322-7531806452c8)
![bet-validate2](https://github.com/ArthurZL/2024LLED/assets/71044771/7467382a-4048-46d3-b0f2-63c64ffc15de)

## Como Configurar Seu Ambiente

## Notas de melhorias
