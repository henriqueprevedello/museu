# museu

- Cadastro da instituição
- Cadastro de acervo
- Cadastro de objetos do acervo com categorias, status, imagens, documentos, videos, audios....
- Cadastro de categorias
- Cadastro de espaços
- Tela de busca de dados do acervo, com vários filtros;
- Tela de check-in dos visitantes
- Painel de admin para os funcionarios gerir todas as informações do museu;


- instituicao
* nome
* informações
* lista de acervos

- acervo
* descricao

- espaço
* descricao
* codigoAcervo

- objeto
* nome
* status
* data
* lista de anexos
* codigoEspaço
* lista de categorias

- usuario
* nome
* email
* senha

- visitas
* nome
* codigoAcervo
* data

-categorias
* nome