# PUCRS/DELL IT ACADEMY 2024 - Turma 20


## Resumo Técnico
Este projeto foi desenvolvido como parte do processo seletivo da DELL, realizado em parceria com Centro de Inovação da PUCRS. O projeto a seguir foi um dos selecionados para as etapas seguintes do processo de seleção dos candidatos.

O projeto tem como objetivo simular o comportamento de um software de apostas e sorteios, utilizando para criação da interface gráfica HTML e CSS, JavaScript para o Front-end, PHP para o Back-end e MySQL como Banco de Dados. 


## Como Configurar Seu Ambiente

Este projeto foi desenvolvido em um ambiente de desenvolvimento local (localhost), para isso foi utilizado o software XAMPP, que pode ser baixado através do link https://www.apachefriends.org/pt_br/index.html.

Após a instalação, recomenda-se executa-lo como administrador para evitar problemas de autorizações, em seguida ative o Apache e MySQL.

![xampp](https://github.com/ArthurZL/2024LLED/assets/71044771/ed565faa-6458-4abc-ac56-f9d1a7809c1f)

Com ambos ativados, acesse seu navegador e conecte-se ao phpmyadmin através da URL http://localhost/phpmyadmin/.

Após isso é necessário executar o script SQL para criação do banco de dados, há duas formas de fazer isso. Você pode clicar no botão *SQL* na interface gráfica do phpmyadmin, copiar todo conteúdo contido no arquivo **script.sql**, que está dentro dos arquivos no código fonte e executa-lo diretamente na interface através das teclas *CTRL + ENTER*, ou exportando o arquivo  **script.sql** através do botão *Exportar*.

![BD-sql](https://github.com/ArthurZL/2024LLED/assets/71044771/c777ec26-7582-484b-8fbe-6cb589cc4a0d)

![BD-exportar](https://github.com/ArthurZL/2024LLED/assets/71044771/148ca810-1289-472a-bf7a-ff3e6ef3764c)

Após a criação das tabelas procura pela pasta htdocs, dentro da pasta xampp, por padrão a instalação é feita no caminho *C:\xampp\htdocs*, nessa pasta você extrairá o código que estará no .zip.

Se tudo ocorreu bem, agora você será capaz de acessar a tela de login, basta digitar na URL de seu navegador http://localhost/2024LLED/index.php.

Vale lembrar que caso o XAMPP já tenha sido previamente instalado, as credenciais de acesso podem não estarem configuradas de acordo com o padrão de instalação, nesse caso será necessário alterar o conteúdo do arquivo **database.php** para deixa-lo de acordo com as suas configurações.

![database](https://github.com/ArthurZL/2024LLED/assets/71044771/11a77896-a1f2-4d43-a00f-8c0da73ff079)


## Funcionalidades
Para tentar criar uma simulação mais realista, optou-se pelo uso de uma tela de login. Esta tela possui como credenciais o CPF único do usuário e uma senha criptografada, além disso a tela conta com um botão para entrar no sistema e um para se registrar.

![login](https://github.com/ArthurZL/2024LLED/assets/71044771/c5818372-98a4-4123-b41e-cffdc43e5a86)


Ao clicar no botão de registro, o usuário será levado para a tela de cadastro, nela será preciso fornecer seu CPF, nome, senha e confirmação de senha.

![signup](https://github.com/ArthurZL/2024LLED/assets/71044771/92cb855e-b026-488e-982c-665e73e4359c)


Caso qualquer um destes campos for deixado em branco ou se a confirmação de senha for distinta da senha, uma mensagem de erro aparecerá e impedirá o cadastro.

![signup-error1](https://github.com/ArthurZL/2024LLED/assets/71044771/68158b55-2358-491c-aa39-34333e727500)

![signup-error2](https://github.com/ArthurZL/2024LLED/assets/71044771/7af5789c-53df-40bf-9e61-0cbccbdf829f)


Ao iniciar a tela de login pelo primeira vez será criado a primeira edição do sorteio e um usuário administrador, para entrar nesta conta baste inserir o CPF **00000000000** e a senha **senhaformeadmin**, após o login o operador será levado para a tela administrativa, onde poderá visualizar todas as apostas feitas ou iniciar o sorteio, ambos apenas para a edição atual.

![home](https://github.com/ArthurZL/2024LLED/assets/71044771/5c28026f-a6ac-46c1-a691-ed2dd16d7046)


Caso opte visualizar as postas registradas até o momento, o usuário administrador será levado para a tabela contendo todas as informações pessoais dos apostadores, bem como os dados de suas apostas. Essas informações também podem ser vistas pelo console através da tecla *F12*.

![show](https://github.com/ArthurZL/2024LLED/assets/71044771/42a81844-5e77-4202-a2c1-704043f04302)

![show-console](https://github.com/ArthurZL/2024LLED/assets/71044771/23cfdd98-f6d8-4ff6-bac6-ec6f170d6240)


Quando o administrador iniciar o sorteio será exibida a tela de resultados, nela haverá informações de **Número de Sorteios Extras**, **Número de Ganhadores**, **Números Sorteados**, **Dados Pessoas dos Vencedores** e **Estatística das Apostas**, estes também podem ser vistos pelo console.

![raffle](https://github.com/ArthurZL/2024LLED/assets/71044771/3294f879-b077-40cd-afad-b3d2ee87af86)

![raffle-console](https://github.com/ArthurZL/2024LLED/assets/71044771/5c99ebac-2abd-4539-9e45-78ace1c86193)


Caso o usuário seja um apostador, logo após realizar o login ele será redirecionado para a tela de apostas, nela há cinco campos para inserir os números desejados para o sorteio, o botão **S** no canto direito que gera cinco números aleatórios para o usuário e um botão para confirmar a aposta.

![bet](https://github.com/ArthurZL/2024LLED/assets/71044771/1d45c7dd-603c-460e-b3ed-9e05da60a34c)


O apostador será impedido de realizar a confirmação caso a quantidade de números escolhidos não esteja adequada ou se valores apostados estiverem fora do intervalo permitido.

![bet-error1](https://github.com/ArthurZL/2024LLED/assets/71044771/dbd3e928-5399-45b7-8ba9-edb4d085c77d)

![bet-error2](https://github.com/ArthurZL/2024LLED/assets/71044771/0efb6f47-a3d8-4e97-9807-0a63bb494b25)

![bet-validate1](https://github.com/ArthurZL/2024LLED/assets/71044771/c001e261-5737-42ff-b322-7531806452c8)

![bet-validate2](https://github.com/ArthurZL/2024LLED/assets/71044771/7467382a-4048-46d3-b0f2-63c64ffc15de)


