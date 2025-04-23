# Engenhoca da Mega Sena
## História
Não lembro bem, mas acredito que esses códigos começaram a ser escritos por volta de 2004. Numa versão mais antiga, antes da primeira refatoração, achei arquivos com registros de resultados de sorteios desse ano. Tudo rodava por scripts procedurais e, pasmem, já ajudou a acertar 2 quinas e algumas dezenas de quadras.
De um tempo para cá, essas estatísticas estão sendo discutidas e, a partir delas, escolhemos os números e, em grupo, apostamos sempre, com um gasto médio mensal de 60 reais por pessoa.
## Roadmaps
### Negócio
- eliminar dados estatísticos duplicados ou não usados
- exibir informações mais simples para quem quiser ter acesso às estatísticas
- gerar uma ferramenta pública que o usuário digite quantos jogos quer gerar e o sistema gera automaticamente
### Técnico
- aprimorar essa documentação
- corrigir as views, removendo os cálculos de lá, movendo para outra camada
- dividir a Controller, pois hoje está tudo lá
- como outras duas pessoas colaboram, preciso acrescentar outra forma de proteção, e não apenas por IP
- executar algum linter
- colocar resultados em cache ou banco de dados, pois a cada carregamento de página, um monte de coisa é recalculada
- para quem quiser utilizar isso (clonar)
  - configurar um docker compose para subir um banco de dados
  - aprimorar o script de importação de resultados de sorteios
- refatorar os cálculos estatísticos e fazê-los serem executados automaticamente ao inserir um novo sorteio

