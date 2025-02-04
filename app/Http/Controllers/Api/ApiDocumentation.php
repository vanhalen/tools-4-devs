<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="Tools4Devs API",
 *     version="1.0.0",
 *     description="API projetada para devs, oferecendo funcionalidades como busca de CEP e endereço, geradores e validadores de documentos, informações de rede e diversos outros recursos úteis para aplicações modernas.",
 *     @OA\Contact(
 *         email="contato@rodrigorchagas.com.br",
 *         name="Rodrigo Chagas",
 *         url="https://rodrigorchagas.com.br"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * ),
 * @OA\ExternalDocumentation(
 *     description="Saiba mais sobre a Tools4Devs",
 *     url="https://tools4devs.rodrigorchagas.com.br/"
 * )
 */
class ApiDocumentation
{
    ##############################################
    ################   ENDEREÇOS   ###############
    ##############################################
    /**
     * @OA\Get(
     *     path="/api/address/cep",
     *     summary="Busca um endereço pelo CEP",
     *     description="Retorna o endereço correspondente ao CEP informado. Caso o CEP não esteja no banco de dados, ele será buscado via APIs externas e salvo automaticamente.",
     *     operationId="searchCep",
     *     tags={"Endereços"},
     *     @OA\Parameter(
     *         name="cep",
     *         in="query",
     *         description="CEP a ser consultado. Deve conter 8 dígitos numéricos (com ou sem formatação).",
     *         required=true,
     *         @OA\Schema(type="string", example="01001-000")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço retornado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="endereco",
     *                 type="object",
     *                 @OA\Property(property="cep", type="string", example="01001-000"),
     *                 @OA\Property(property="logradouro", type="string", example="Praça da Sé"),
     *                 @OA\Property(property="complemento", type="string", example="lado ímpar"),
     *                 @OA\Property(property="unidade", type="string", example="Edifício da Sé"),
     *                 @OA\Property(property="bairro", type="string", example="Sé"),
     *                 @OA\Property(property="localidade", type="string", example="São Paulo"),
     *                 @OA\Property(property="uf", type="string", example="SP"),
     *                 @OA\Property(property="estado", type="string", example="São Paulo"),
     *                 @OA\Property(property="regiao", type="string", example="Sudeste"),
     *                 @OA\Property(property="ibge", type="string", example="3550308"),
     *                 @OA\Property(property="gia", type="string", example="1004"),
     *                 @OA\Property(property="ddd", type="string", example="11"),
     *                 @OA\Property(property="siafi", type="string", example="7107"),
     *                 @OA\Property(property="localizacao_tipo", type="string", example="Point"),
     *                 @OA\Property(property="localizacao_longitude", type="string", example="-46.63428906534399"),
     *                 @OA\Property(property="localizacao_latitude", type="string", example="-23.550430309662772")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na consulta do CEP",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="CEP inválido. Certifique-se de que possui 8 dígitos.")
     *             )
     *         )
     *     )
     * )
     */
    public function addressCep(){}

    /**
     * @OA\Get(
     *     path="/api/address/street",
     *     summary="Busca endereços pelo nome da rua",
     *     description="Busca endereços baseados no nome da rua fornecido. O resultado será ordenado pela proximidade do nome do logradouro e terá um limite máximo de 50 registros. Quanto mais específicos forem os parâmetros de entrada, maior será a precisão do resultado.  
     *     Exemplos de pesquisa:  
     *     - /api/address/street?uf=SP&city=São Paulo&street=João  
     *     - /api/address/street?uf=SP&city=São Paulo&street=João Antônio  
     *     - /api/address/street?uf=SP&city=São Paulo&street=João,Antônio  
     *     Quando múltiplos termos são informados com vírgula, a busca retornará resultados contendo ambos os termos, independentemente da ordem.",
     *     operationId="searchStreet",
     *     tags={"Endereços"},
     *     @OA\Parameter(
     *         name="uf",
     *         in="query",
     *         description="Unidade Federativa (UF) onde será feita a busca. Deve conter exatamente 2 caracteres.",
     *         required=true,
     *         @OA\Schema(type="string", example="SP")
     *     ),
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="Nome da cidade onde será feita a busca. Deve conter no mínimo 3 caracteres.",
     *         required=true,
     *         @OA\Schema(type="string", example="São Paulo")
     *     ),
     *     @OA\Parameter(
     *         name="street",
     *         in="query",
     *         description="Nome da rua ou palavras-chave associadas ao logradouro. Múltiplos termos podem ser separados por vírgula para aumentar a precisão.",
     *         required=true,
     *         @OA\Schema(type="string", example="João,Antônio")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereços encontrados com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="endereco",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="cep", type="string", example="04696-210"),
     *                     @OA\Property(property="logradouro", type="string", example="Avenida Doutor Antonio João Abdalla"),
     *                     @OA\Property(property="complemento", type="string", example=""),
     *                     @OA\Property(property="unidade", type="string", example=""),
     *                     @OA\Property(property="bairro", type="string", example="Jurubatuba"),
     *                     @OA\Property(property="localidade", type="string", example="São Paulo"),
     *                     @OA\Property(property="uf", type="string", example="SP"),
     *                     @OA\Property(property="estado", type="string", example="São Paulo"),
     *                     @OA\Property(property="regiao", type="string", example="Sudeste"),
     *                     @OA\Property(property="ibge", type="string", example="3550308"),
     *                     @OA\Property(property="gia", type="string", example="1004"),
     *                     @OA\Property(property="ddd", type="string", example="11"),
     *                     @OA\Property(property="siafi", type="string", example="7107"),
     *                     @OA\Property(property="localizacao_tipo", type="string", example="Point"),
     *                     @OA\Property(property="localizacao_longitude", type="number", nullable=true, example=null),
     *                     @OA\Property(property="localizacao_latitude", type="number", nullable=true, example=null)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na busca por endereços",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="UF inválida. Certifique-se de que possui exatamente 2 caracteres.")
     *             )
     *         )
     *     )
     * )
     */
    public function addressStreet(){}

    /**
     * @OA\Get(
     *     path="/api/address/city",
     *     summary="Busca ou lista cidades",
     *     description="Busca ou lista cidades com base nos parâmetros opcionais fornecidos, como UF e nome da cidade. Se nenhum parâmetro for fornecido, retorna todas as cidades disponíveis.",
     *     operationId="searchCity",
     *     tags={"Endereços"},
     *     @OA\Parameter(
     *         name="uf",
     *         in="query",
     *         description="Unidade Federativa (UF) para filtrar a busca. Deve conter exatamente 2 caracteres.",
     *         required=false,
     *         @OA\Schema(type="string", example="SP")
     *     ),
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="Nome parcial ou completo da cidade a ser buscada. Deve conter no mínimo 3 caracteres.",
     *         required=false,
     *         @OA\Schema(type="string", example="São Paulo")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cidades encontradas com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="cidade",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="ibge", type="string", example="3550308"),
     *                     @OA\Property(property="cidade", type="string", example="São Paulo"),
     *                     @OA\Property(property="uf", type="string", example="SP"),
     *                     @OA\Property(property="cep", type="string", example="00000000")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na busca por cidades",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="UF inválida. Certifique-se de que possui exatamente 2 caracteres.")
     *             )
     *         )
     *     )
     * )
     */
    public function addressCity(){}





    ##############################################
    ################   GERADORES   ###############
    ##############################################
    /**
     * @OA\Get(
     *     path="/api/generator/cpf",
     *     summary="Gera um CPF válido",
     *     description="Gera um CPF válido, podendo ser formatado ou não, e com a opção de gerar de um estado específico.",
     *     operationId="gerarCPF",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="formatted",
     *         in="query",
     *         description="Define se o CPF será formatado (true ou false). Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="uf",
     *         in="query",
     *         description="UF (sigla do estado) para gerar um CPF específico. Caso não informado, gera um CPF de qualquer estado.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="SP",
     *             enum={"AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS","MT","PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC","SE","SP","TO"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="CPF gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="cpf", type="string", example="123.456.789-00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar o CPF",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar CPF.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorCpf(){}

    /**
     * @OA\Get(
     *     path="/api/generator/rg",
     *     summary="Gera um RG válido",
     *     description="Gera um RG válido, podendo ser formatado ou não, conforme o parâmetro informado.",
     *     operationId="gerarRG",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="formatted",
     *         in="query",
     *         description="Define se o RG será formatado (true ou false). Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="RG gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="rg", type="string", example="12.345.678-9")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar o RG",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar RG.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorRg(){}

    /**
     * @OA\Get(
     *     path="/api/generator/cnpj",
     *     summary="Gera um CNPJ válido",
     *     description="Gera um CNPJ válido, podendo ser formatado ou não, conforme o parâmetro informado.",
     *     operationId="gerarCNPJ",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="formatted",
     *         in="query",
     *         description="Define se o CNPJ será formatado (true ou false). Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="CNPJ gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="cnpj", type="string", example="12.345.678/0001-95")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar o CNPJ",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar CNPJ.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorCnpj(){}

    /**
     * @OA\Get(
     *     path="/api/generator/titulo-eleitor",
     *     summary="Gera um Título de Eleitor válido",
     *     description="Gera um Título de Eleitor válido, podendo ser formatado ou não, e com a opção de gerar com base em uma UF específica.",
     *     operationId="gerarTituloEleitor",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="formatted",
     *         in="query",
     *         description="Define se o Título de Eleitor será formatado (true ou false). Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="uf",
     *         in="query",
     *         description="UF (sigla do estado) para gerar um Título de Eleitor específico. Caso não informado, gera aleatoriamente.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="SP",
     *             enum={"AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS","MT","PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC","SE","SP","TO"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Título de Eleitor gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="tituloEleitor", type="string", example="1234 5678 1234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar o Título de Eleitor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar o Título de Eleitor.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorTituloEleitor(){}

    /**
     * @OA\Get(
     *     path="/api/generator/pis-pasep",
     *     summary="Gera um PIS/PASEP válido",
     *     description="Gera um PIS/PASEP válido, podendo ser formatado ou não, conforme o parâmetro informado.",
     *     operationId="gerarPISPASEP",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="formatted",
     *         in="query",
     *         description="Define se o PIS/PASEP será formatado (true ou false). Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PIS/PASEP gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="pispasep", type="string", example="123.45678.90-1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar o PIS/PASEP",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar PIS/PASEP.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorPisPasep(){}

    /**
     * @OA\Get(
     *     path="/api/generator/certidao",
     *     summary="Gera uma certidão válida",
     *     description="Gera uma certidão válida com base nos parâmetros informados, como tipo, estado, ano de registro (a partir de 2010) e cartório. A certidão pode ser formatada ou não.",
     *     operationId="gerarCertidao",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Tipo de certidão a ser gerada. Padrão: nascimento. Valores permitidos: nascimento, casamento, obito, casamento-religioso.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="nascimento",
     *             enum={"nascimento", "casamento", "obito", "casamento-religioso"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="uf",
     *         in="query",
     *         description="UF (sigla do estado) onde a certidão será registrada. Caso não informado, gera aleatoriamente.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="SP",
     *             enum={"AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS","MT","PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC","SE","SP","TO"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="year",
     *         in="query",
     *         description="Ano do registro da certidão. Caso não informado, gera aleatoriamente.",
     *         required=false,
     *         @OA\Schema(type="integer", example=2023)
     *     ),
     *     @OA\Parameter(
     *         name="notary",
     *         in="query",
     *         description="Código do cartório onde a certidão será registrada. Caso não informado, gera aleatoriamente.",
     *         required=false,
     *         @OA\Schema(type="integer", example=50)
     *     ),
     *     @OA\Parameter(
     *         name="formatted",
     *         in="query",
     *         description="Define se a certidão será formatada (true ou false). Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Certidão gerada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="certidao", type="string", example="12345.67.89.0001.01234.5678.9012345-67"),
     *             @OA\Property(property="tipo", type="string", example="nascimento")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar a certidão",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar a certidão.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorCertidao(){}

    /**
     * @OA\Get(
     *     path="/api/generator/senha",
     *     summary="Gera uma senha com base nos parâmetros fornecidos",
     *     description="Gera uma senha personalizada de acordo com os critérios definidos, como tamanho, uso de letras maiúsculas, minúsculas, números e caracteres especiais.",
     *     operationId="gerarSenha",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="length",
     *         in="query",
     *         description="Tamanho da senha a ser gerada. Padrão: 6.",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="uppercase",
     *         in="query",
     *         description="Define se a senha deve conter letras maiúsculas. Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="lowercase",
     *         in="query",
     *         description="Define se a senha deve conter letras minúsculas. Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="numbers",
     *         in="query",
     *         description="Define se a senha deve conter números. Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="specials",
     *         in="query",
     *         description="Define se a senha deve conter caracteres especiais. Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Senha gerada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="senha", type="string", example="Abc123!@#")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar a senha",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar senha.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorSenha(){}

    /**
     * @OA\Get(
     *     path="/api/generator/endereco",
     *     summary="Gera um endereço válido",
     *     description="Gera um endereço válido com base na UF fornecida e com a opção de formatar o CEP.",
     *     operationId="gerarEndereco",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="uf",
     *         in="query",
     *         description="UF (sigla do estado) onde o endereço será gerado. Caso não informado, gera aleatoriamente.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="SP",
     *             enum={"AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS","MT","PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC","SE","SP","TO"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="formatted",
     *         in="query",
     *         description="Define se o CEP será formatado (true ou false). Padrão: true.",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="endereco", type="object",
     *                 @OA\Property(property="cep", type="string", example="12345-678"),
     *                 @OA\Property(property="logradouro", type="string", example="Rua das Flores"),
     *                 @OA\Property(property="complemento", type="string", example="Casa 123"),
     *                 @OA\Property(property="unidade", type="string", example="Condomínio das flores"),
     *                 @OA\Property(property="bairro", type="string", example="Jardim Primavera"),
     *                 @OA\Property(property="localidade", type="string", example="São Paulo"),
     *                 @OA\Property(property="uf", type="string", example="SP"),
     *                 @OA\Property(property="estado", type="string", example="São Paulo"),
     *                 @OA\Property(property="regiao", type="string", example="Sudeste"),
     *                 @OA\Property(property="ibge", type="string", example="1231231"),
     *                 @OA\Property(property="gia", type="string", example="1234"),
     *                 @OA\Property(property="ddd", type="string", example="11"),
     *                 @OA\Property(property="siafi", type="string", example="1234"),
     *                 @OA\Property(property="localizacao_tipo", type="string", example="Point"),
     *                 @OA\Property(property="localizacao_longitude", type="string", example="-11.123456789123456"),
     *                 @OA\Property(property="localizacao_latitude", type="string", example="-22.345678912345678")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao gerar o endereço",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar endereço.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorEndereco(){}

    /**
     * @OA\Get(
     *     path="/api/generator/lorem-ipsum",
     *     summary="Gera texto Lorem Ipsum",
     *     description="Gera um texto Lorem Ipsum com base nos parâmetros fornecidos, como tipo, formato e quantidade.",
     *     operationId="generateLoremIpsum",
     *     tags={"Geradores"},
     *     @OA\Parameter(
     *         name="length",
     *         in="query",
     *         description="Quantidade de parágrafos ou palavras a serem gerados. Padrão: 5.",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=5
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Tipo de conteúdo a ser gerado: 'paragrafos' ou 'palavras'. Padrão: 'paragrafos'.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"paragrafos", "palavras"},
     *             example="paragrafos"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="format",
     *         in="query",
     *         description="Formato do conteúdo: 'texto' ou 'html'. Padrão: 'texto'.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"texto", "html"},
     *             example="texto"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Texto Lorem Ipsum gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="lorem", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na geração do Lorem Ipsum",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao gerar o Lorem Ipsum.")
     *             )
     *         )
     *     )
     * )
     */
    public function generatorLoremIpsum(){}





    ##############################################
    ############   REDE E INTERNET   #############
    ##############################################
    /**
     * @OA\Get(
     *     path="/api/network/ip",
     *     summary="Retorna os endereços IP do usuário",
     *     description="Retorna o endereço IP local (IPv4 e IPv6) do usuário que está acessando a API.",
     *     operationId="getIp",
     *     tags={"Rede e Internet"},
     *     @OA\Response(
     *         response=200,
     *         description="IPs retornados com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="ipv4", type="string", nullable=true, example="192.168.0.1"),
     *             @OA\Property(property="ipv6", type="string", nullable=true, example="2001:db8::ff00:42:8329")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao obter os endereços IP",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao obter os endereços IP.")
     *             )
     *         )
     *     )
     * )
     */
    public function networkGetIp(){}

    /**
     * @OA\Get(
     *     path="/api/network/browser",
     *     summary="Retorna o navegador do usuário",
     *     description="Retorna informações referente ao navegador do usuário.",
     *     operationId="getBrowser",
     *     tags={"Rede e Internet"},
     *     @OA\Response(
     *         response=200,
     *         description="Informações do navegador retornadas com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="browser", type="string", example="Chrome"),
     *             @OA\Property(property="version", type="string", example="132.0.0.0")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao obter informações do navegador",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao obter informações do navegador.")
     *             )
     *         )
     *     )
     * )
     */
    public function networkGetBrowser(){}

    /**
     * @OA\Get(
     *     path="/api/network/system",
     *     summary="Retorna o sistema operacional do usuário",
     *     description="Retorna informações referentes ao sistema operacional do usuário.",
     *     operationId="getSystem",
     *     tags={"Rede e Internet"},
     *     @OA\Response(
     *         response=200,
     *         description="Informações do sistema operacional retornadas com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="system", type="string", example="Windows"),
     *             @OA\Property(property="version", type="string", example="10")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao obter informações do sistema operacional",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao obter informações do sistema operacional.")
     *             )
     *         )
     *     )
     * )
     */
    public function networkGetSystem(){}

    /**
     * @OA\Get(
     *     path="/api/network/resolve-dns",
     *     summary="Resolve um domínio para IP ou vice-versa",
     *     description="Resolve o IP associado a um domínio ou realiza a resolução reversa de IP para hostname.",
     *     operationId="resolveDns",
     *     tags={"Rede e Internet"},
     *     @OA\Parameter(
     *         name="host",
     *         in="query",
     *         description="O domínio ou endereço IP a ser resolvido.",
     *         required=true,
     *         @OA\Schema(type="string", example="google.com")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resolução DNS realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="host", type="string", example="google.com"),
     *             @OA\Property(property="resolved_ip", type="string", example="142.250.72.238"),
     *             @OA\Property(property="resolved_host", type="string", example="lhr25s34-in-f14.1e100.net")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao resolver o domínio ou IP",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao resolver o domínio ou IP.")
     *             )
     *         )
     *     )
     * )
     */
    public function networkResolveDns(){}

    /**
     * @OA\Get(
     *     path="/api/network/port-test",
     *     summary="Testa se uma porta está aberta em um IP ou domínio",
     *     description="Verifica se uma porta específica está aberta em um endereço IP ou domínio fornecido.",
     *     operationId="portTest",
     *     tags={"Rede e Internet"},
     *     @OA\Parameter(
     *         name="host",
     *         in="query",
     *         description="O domínio ou endereço IP a ser testado.",
     *         required=true,
     *         @OA\Schema(type="string", example="google.com")
     *     ),
     *     @OA\Parameter(
     *         name="port",
     *         in="query",
     *         description="A porta a ser testada.",
     *         required=true,
     *         @OA\Schema(type="integer", example=80)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Teste de porta realizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="host", type="string", example="google.com"),
     *             @OA\Property(property="port", type="integer", example=80),
     *             @OA\Property(property="is_open", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao testar a porta",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao testar a porta.")
     *             )
     *         )
     *     )
     * )
     */
    public function networkPortTest(){}





    ##############################################
    ###############   VALIDADORES   ##############
    ##############################################
    /**
     * @OA\Get(
     *     path="/api/validator/cpf",
     *     summary="Valida um CPF",
     *     description="Verifica se o CPF informado é válido.",
     *     operationId="validateCpf",
     *     tags={"Validadores"},
     *     @OA\Parameter(
     *         name="cpf",
     *         in="query",
     *         description="CPF a ser validado.",
     *         required=true,
     *         @OA\Schema(type="string", example="123.456.789-09")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validação do CPF realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="cpf", type="string", example="123.456.789-09"),
     *             @OA\Property(property="is_valid", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao validar o CPF",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao validar o CPF.")
     *             )
     *         )
     *     )
     * )
     */
    public function validatorCpf(){}

    /**
     * @OA\Get(
     *     path="/api/validator/rg",
     *     summary="Valida um RG",
     *     description="Verifica se o RG informado é válido.",
     *     operationId="validateRg",
     *     tags={"Validadores"},
     *     @OA\Parameter(
     *         name="rg",
     *         in="query",
     *         description="RG a ser validado.",
     *         required=true,
     *         @OA\Schema(type="string", example="12.345.678-9")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validação do RG realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="rg", type="string", example="12.345.678-9"),
     *             @OA\Property(property="is_valid", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao validar o RG",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao validar o RG.")
     *             )
     *         )
     *     )
     * )
     */
    public function validatorRg(){}

    /**
     * @OA\Get(
     *     path="/api/validator/cnpj",
     *     summary="Valida um CNPJ",
     *     description="Verifica se o CNPJ informado é válido.",
     *     operationId="validateCnpj",
     *     tags={"Validadores"},
     *     @OA\Parameter(
     *         name="cnpj",
     *         in="query",
     *         description="CNPJ a ser validado.",
     *         required=true,
     *         @OA\Schema(type="string", example="12.345.678/0001-95")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validação do CNPJ realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="cnpj", type="string", example="12.345.678/0001-95"),
     *             @OA\Property(property="is_valid", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao validar o CNPJ",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao validar o CNPJ.")
     *             )
     *         )
     *     )
     * )
     */
    public function validatorCnpj(){}

    /**
     * @OA\Get(
     *     path="/api/validator/titulo-eleitor",
     *     summary="Valida um Título de Eleitor",
     *     description="Verifica se o Título de Eleitor informado é válido e retorna o estado (UF) associado.",
     *     operationId="validateTituloEleitor",
     *     tags={"Validadores"},
     *     @OA\Parameter(
     *         name="titulo",
     *         in="query",
     *         description="Título de Eleitor a ser validado.",
     *         required=true,
     *         @OA\Schema(type="string", example="1234 5678 1234")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validação do Título de Eleitor realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="titulo", type="string", example="1234 5678 1234"),
     *             @OA\Property(property="uf", type="string", example="SP"),
     *             @OA\Property(property="is_valid", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao validar o Título de Eleitor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao validar o Título de Eleitor.")
     *             )
     *         )
     *     )
     * )
     */
    public function validatorTituloEleitor(){}

    /**
     * @OA\Get(
     *     path="/api/validator/pis-pasep",
     *     summary="Valida um PIS/PASEP",
     *     description="Verifica se o PIS/PASEP informado é válido.",
     *     operationId="validatePisPasep",
     *     tags={"Validadores"},
     *     @OA\Parameter(
     *         name="pispasep",
     *         in="query",
     *         description="PIS/PASEP a ser validado.",
     *         required=true,
     *         @OA\Schema(type="string", example="123.45678.90-1")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validação do PIS/PASEP realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="pispasep", type="string", example="123.45678.90-1"),
     *             @OA\Property(property="is_valid", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao validar o PIS/PASEP",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao validar o PIS/PASEP.")
     *             )
     *         )
     *     )
     * )
     */
    public function validatorPisPasep(){}

    /**
     * @OA\Get(
     *     path="/api/validator/certidao",
     *     summary="Valida uma certidão",
     *     description="Verifica se a certidão informada é válida e retorna informações detalhadas como tipo, estado, ano e cartório.",
     *     operationId="validateCertidao",
     *     tags={"Validadores"},
     *     @OA\Parameter(
     *         name="certidao",
     *         in="query",
     *         description="Número da certidão a ser validado.",
     *         required=true,
     *         @OA\Schema(type="string", example="12345.67.89.0001.01234.5678.9012345-67")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validação da certidão realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="certidao", type="string", example="12345.67.89.0001.01234.5678.9012345-67"),
     *             @OA\Property(property="is_valid", type="boolean", example=true),
     *             @OA\Property(property="tipo", type="string", example="nascimento"),
     *             @OA\Property(property="uf", type="string", example="SP"),
     *             @OA\Property(property="ano", type="integer", example=2023),
     *             @OA\Property(property="cod_cartorio", type="integer", example=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao validar a certidão",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao validar a certidão.")
     *             )
     *         )
     *     )
     * )
     */
    public function validatorCertiao(){}

    /**
     * @OA\Get(
     *     path="/api/validator/ip",
     *     summary="Valida um endereço IP",
     *     description="Verifica se o endereço IP informado é válido e se é público ou privado.",
     *     operationId="validateIp",
     *     tags={"Validadores"},
     *     @OA\Parameter(
     *         name="ip",
     *         in="query",
     *         description="Endereço IP a ser validado.",
     *         required=true,
     *         @OA\Schema(type="string", example="192.168.0.1")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validação do IP realizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="ip", type="string", example="192.168.0.1"),
     *             @OA\Property(property="is_valid", type="boolean", example=true),
     *             @OA\Property(property="is_public", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao validar o endereço IP",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Erro ao validar o endereço IP.")
     *             )
     *         )
     *     )
     * )
     */
    public function validatorIp(){}





    ##############################################
    ################   FERIADOS    ###############
    ##############################################
    /**
     * @OA\Get(
     *     path="/api/holidays/{year}",
     *     summary="Lista todos os feriados nacionais",
     *     description="Retorna a lista de feriados nacionais fixos e móveis para o ano especificado.",
     *     operationId="getHolidays",
     *     tags={"Feriados"},
     *     @OA\Parameter(
     *         name="year",
     *         in="path",
     *         description="Ano para o qual os feriados serão listados (entre 1900 e 2199).",
     *         required=true,
     *         @OA\Schema(type="integer", example=2025)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Feriados listados com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="date", type="string", example="2025-04-21"),
     *                 @OA\Property(property="name", type="string", example="Tiradentes"),
     *                 @OA\Property(property="type", type="string", example="nacional")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na requisição",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="message", type="string", example="Ano fora do intervalo suportado entre 1900 e 2199.")
     *             )
     *         )
     *     )
     * )
     */
    public function holidays(){}
}
