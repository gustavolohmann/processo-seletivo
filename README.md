
# Backend Processo Seletivo

/**
 * Processo Seletivo PHP
 *
 * Este projeto foi desenvolvido como parte de um processo seletivo, utilizando PHP puro
 * com uma estrutura organizada que segue o padrão PSR-4.
 *
 * ## Estrutura do Projeto
 * O projeto utiliza o padrão de autoloading PSR-4, conforme especificado no arquivo `composer.json`.
 * As classes são carregadas automaticamente a partir do namespace `Glohm\ProcessoSeletivo` com base
 * na estrutura de diretórios em `src/`.
 *
 * ## Requisitos
 * Para executar o projeto, é necessário ter os seguintes recursos instalados:
 * - PHP 8+
 * - Apache (ou XAMPP para facilitar)
 * - MySQL (banco de dados)
 * - Composer (para autoload das classes via PSR-4)
 *
 * ## Como Rodar o Projeto
 * 1. Clone o repositório:
 *    ```bash
 *    git clone https://github.com/seu-usuario/seu-repositorio.git
 *    cd seu-repositorio
 *    ```
 * 2. Instale as dependências com o Composer:
 *    ```bash
 *    composer install
 *    ```
 * 3. Inicie o servidor local na porta 8000:
 *    ```bash
 *    php -S localhost:8000
 *    ```
 * 4. Acesse o projeto no navegador:
 *    ```
 *    http://localhost:8000
 *    ```
 *
 * ## Banco de Dados
 * Certifique-se de que o MySQL está rodando e configure as credenciais de conexão no arquivo
 * responsável pela conexão com o banco de dados (ex: `src/Db.php`).
 *
 * ### Estrutura do Banco de Dados
 * - **DB:** `db_processo_seletivo`
 * - **Tabelas:**
 *   - `alarmes`: Contém informações sobre os alarmes.
 *   - `alarmes_atuados`: Registra os alarmes atuados e seus status.
 *   - `classificacoes`: Define as classificações dos alarmes.
 *   - `equipamentos`: Armazena informações sobre os equipamentos.
 *   - `tipos_equipamento`: Define os tipos de equipamentos.
 *
 * ### Exemplo de Colunas
 * - `alarmes`:
 *   - `id` (int, PK, AI): Identificador do alarme.
 *   - `descricao` (text): Descrição do alarme.
 *   - `classificacao_id` (int): FK para classificações.
 *   - `data_cadastro` (timestamp): Data de criação do alarme.
 *   - `equipamento_id` (int): FK para equipamentos.
 * - `alarmes_atuados`:
 *   - `id` (int, PK, AI): Identificador.
 *   - `alarme_id` (int): FK para alarmes.
 *   - `data_entrada` (timestamp): Data de início da atuação.
 *   - `data_saida` (timestamp): Data de fim da atuação.
 *   - `status` (enum): Status do alarme ('Ativo', 'Inativo').
 * - `classificacoes`:
 *   - `id` (int, PK, AI): Identificador da classificação.
 *   - `nome` (varchar(50)): Nome da classificação.
 * - `equipamentos`:
 *   - `id` (int, PK, AI): Identificador do equipamento.
 *   - `nome` (varchar(255)): Nome do equipamento.
 *   - `numero_serie` (varchar(100)): Número de série.
 *   - `tipo_id` (int): FK para tipos de equipamento.
 *   - `data_cadastro` (datetime): Data de cadastro.
 * - `tipos_equipamento`:
 *   - `id` (int, PK, AI): Identificador do tipo.
 *   - `nome` (varchar(50)): Nome do tipo de equipamento.
 */



