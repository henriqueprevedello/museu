# museu

- Cadastro da instituição
- Cadastro de acervo
- Cadastro de objetos do acervo com categorias, status, imagens, documentos, videos, audios....
- Cadastro de categorias
- Cadastro de espaços
- Tela de busca de dados do acervo, com vários filtros;
- Tela de check-in dos visitantes
- Painel de admin para os funcionarios gerir todas as informações do museu;

## Entidades

### Instituicao
* nome
* informações
* lista de acervos

### Acervo
* descricao

### Espaço
* descricao
* codigoAcervo

### Objeto
* nome
* Descrição
* status
* data de criação
* lista de anexos
* codigoEspaço
* lista de categorias

### Anexo
* Nome
* Arquivo

### Usuario
* nome
* email
* senha

### Visita
* nome
* codigoAcervo
* data

### Categoria
* nome
