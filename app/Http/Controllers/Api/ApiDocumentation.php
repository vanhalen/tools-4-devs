<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="Tools4Devs API",
 *     version="1.0.0",
 *     description="API para geração de documentos e dados válidos, projetada para devs que precisam de recursos como CPF, RG, senhas e outros geradores automatizados.",
 *     @OA\Contact(
 *         email="contato@rodrigorchagas.com.br",
 *         name="Rodrigo Chagas",
 *         url="https://rodrigorchagas.com.br"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
class ApiDocumentation
{
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="cpf", type="string", example="123.456.789-00")
     *             )
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="rg", type="string", example="12.345.678-9")
     *             )
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="cnpj", type="string", example="12.345.678/0001-95")
     *             )
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="tituloEleitor", type="string", example="1234 5678 1234")
     *             )
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="pispasep", type="string", example="123.45678.90-1")
     *             )
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
     *     description="Gera uma certidão válida com base nos parâmetros informados, como tipo, estado, ano de registro e cartório. A certidão pode ser formatada ou não.",
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
     *         @OA\Schema(type="integer", example=123)
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="certidao", type="string", example="12345.67.89.0001.01234.5678.9012345-67"),
     *                 @OA\Property(property="tipo", type="string", example="nascimento")
     *             )
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="senha", type="string", example="Abc123!@#")
     *             )
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="endereco", type="object",
     *                     @OA\Property(property="cep", type="string", example="12345-678"),
     *                     @OA\Property(property="logradouro", type="string", example="Rua das Flores"),
     *                     @OA\Property(property="bairro", type="string", example="Jardim Primavera"),
     *                     @OA\Property(property="cidade", type="string", example="São Paulo"),
     *                     @OA\Property(property="estado", type="string", example="SP")
     *                 )
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
     *     description="Este endpoint gera texto Lorem Ipsum com base nos parâmetros fornecidos, como tipo, formato e quantidade.",
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="lorem", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit...")
     *             )
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
}
