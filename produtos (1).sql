-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/05/2026 às 04:18
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `produtos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cupons`
--

CREATE TABLE `cupons` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `tipo` enum('porcentagem','fixo') NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `ativo` enum('sim','nao') DEFAULT 'sim',
  `criado_em` datetime DEFAULT current_timestamp(),
  `valor_minimo` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cupons`
--

INSERT INTO `cupons` (`id`, `codigo`, `tipo`, `valor`, `ativo`, `criado_em`, `valor_minimo`) VALUES
(6, '10OFF', 'porcentagem', 10.00, 'sim', '2026-05-28 20:57:50', 200.00),
(7, '200M', 'fixo', 200.00, 'sim', '2026-05-28 20:58:06', 550.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_nome` varchar(150) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `numero` varchar(30) DEFAULT NULL,
  `complemento` varchar(150) DEFAULT NULL,
  `forma_pagamento` varchar(30) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `prazo_entrega` varchar(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Aprovado',
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_nome`, `cep`, `endereco`, `cidade`, `numero`, `complemento`, `forma_pagamento`, `total`, `prazo_entrega`, `status`, `criado_em`) VALUES
(10, 'cliente1', '85010-000', 'Avenida XV de Novembro', 'Guarapuava', '26', 'Ap 04', 'pix', 383.33, '2', 'Aprovado', '2026-05-28 21:00:43'),
(11, 'cliente2', '69900-004', 'Rua Barbosa Lima', 'Rio Branco', '285', '', 'cartao', 1539.54, '7', 'Aprovado', '2026-05-28 21:01:30'),
(12, 'cliente3', '84020-000', 'Rua Afonso Celso', 'Ponta Grossa', '131', '', 'pix', 673.94, '3', 'Aprovado', '2026-05-28 21:02:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `estoque` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `categoria`, `estoque`, `imagem`, `status`, `criado_em`) VALUES
(8, 'Bola de Basquete NBA DRV', 'Inspirada no impulso que vive dentro de cada aspirante a NBA. A tecnologia Inflation Retention Lining cria uma retenção de ar mais duradoura com esta bola projetada para durabilidade máxima em quadras externas.', 169.90, 'bolas', 30, '69c294f0780a2_WTB9300XB__1.webp', 'ativo', '2026-03-24 13:43:12'),
(9, 'Bola de Basquete NBA DRV Azul', 'Inspirado pelo impulso que vive dentro de cada esperançoso da NBA. O Wilson NBA DRV Basketball é projetado para jogar ao ar livre e construído para resistir aos elementos. O forro de retenção de enchimento cria retenção de ar mais duradoura com esta bola projetada para máxima durabilidade ao ar livre.', 131.75, 'bolas', 15, '69c295664d8aa_816FBN1CY9L._AC_UF1000,1000_QL80_.jpg', 'ativo', '2026-03-24 13:45:10'),
(10, 'Bola de Basquete NBA Player Icon Wilson', 'A Bola de Basquete NBA Player Icon Outdoor molda a vida dos melhores atletas do mundo e, em troca, eles evoluem o jogo com seu estilo, engenhosidade e criatividade.\r\nCelebrando o talento de cada jogador, eles são mais do que cores ou uma camisa, eles representam o que abre caminho no jogo de hoje. Os momentos cruciais que cada jogador cria na quadra ajudam a contar a história da nossa liga, pois cada um escreve seu próprio capítulo.', 238.90, 'bolas', 16, '69c2966f32077_bola-de-basquete-nba-player-icon-wilson--21fa08a2eadf45d258c72c479ff19914.jpg', 'ativo', '2026-03-24 13:49:35'),
(11, 'Bola De Basquete Wilson NBA Team Graffiti GS Warriors Tamanho 7', 'A Bola De Basquete Wilson NBA Team Graffiti GS Warriors Tam 7 une desempenho e estilo, com visual oficial do time. Ideal para jogos em quadras externas, oferece durabilidade e excelente aderência.', 179.90, 'bolas', 23, '69c296a16d569_wz4024510xb7-bola-de-basquete-wilson-nba-team-graffiti-tam-7-gs-warriors.jpg', 'ativo', '2026-03-24 13:50:25'),
(12, 'WILSON Bolas de basquete NBA Forge Plus para uso interno/externo - Tamanho 7', 'Tecnologia de profundidade dupla: um canal reprojetado cria um bolso mais profundo para melhorar a aderência e melhorar sua sensação para o jogo. Capa parcialmente reciclada com sensação pura: uma sensação de nível profissional e durabilidade com um suporte feito de 42% de plásticos reciclados pós-consumo', 325.70, 'bolas', 30, '69c296f52f19c_91l-Gwg8CHL._AC_UF1000,1000_QL80_.jpg', 'ativo', '2026-03-24 13:51:49'),
(13, 'WILSON Réplica de bolas de basquete NCAA', 'Wilson Réplica de basquete NCAA - Tamanho 18 - 75 cm, vermelho/branco/azul\r\nTAMANHOS: Variações de cor disponíveis em 75 cm (meninos de 12 anos ou mais) e 72 cm (meninas de 9 anos ou mais e meninos de 9 a 11 anos)', 440.50, 'bolas', 46, '69c2983372233_81DwWNHl81L._AC_UF1000,1000_QL80_.jpg', 'ativo', '2026-03-24 13:57:07'),
(14, 'Bola De Basquete Spalding Downtown Black Original #7', '- Bola Downtown Black é estilo exclusivo para o (a) basqueteiro(a);\r\n- Painel black com logos em branco para melhor destaque;\r\n- Bola de basquete tamanho 7 oficial igual ou acima de 12 anos masculino;\r\n- Revestimento em borracha durável e excelente grip;\r\n- Canaletas acentuadas para melhor pegada e manuseio;\r\n- Ideal para outdoor, jogo em parques, ruas e quadras de cimento;\r\n- Miolo removível e lubrificado;\r\n- Câmara de ar 100% de borracha butílica para boa retenção de ar.', 152.30, 'bolas', 31, '69c298fbec17c_bola_de_basquete_spalding_downtown_black_original_7_6871_1_b967834f9e5186428b0e42a69a2221b0_20240515181427.webp', 'ativo', '2026-03-24 14:00:27'),
(15, 'Spalding Zi/O Excel Basquetebol interno-externo, 75 cm', 'Pronto para mergulhar nas redes e tropeçar nos defensores. A bola de basquete Spalding Zi/O Excel para ambientes internos e externos tem suporte de espuma para um salto sólido, tanto na academia quanto na garagem. A capa composta é macia e ligeiramente aderente, tornando a bola fácil de manusear.', 129.90, 'bolas', 85, '69c2995716060_Spalding--Precision-TF-1000-Indoor-Game-Basketball---Brown.jpg', 'ativo', '2026-03-24 14:01:59'),
(16, 'Bola Basquete Spalding React TF 250 All Surface - Cor: Laranja', 'Aprovada pela FIBA (Federação Internacional de Basquetebol), a Bola Spalding React TF-250 possui estrutura em microfibra de PU, texturizada e reforçada que contribui para o melhor desempenho durante jogos/partidas, principalmente nas quadras.\r\n\r\nDe uso oficial, a Bola possui ainda ótima aderência que oferece firmeza e estabilidade durante os lances e enterradas na cesta.\r\n\r\nAlém disso, a Bola de Basquete Spalding apresenta o logo da marca em destaque que confere a qualidade do produto. Não perca a oportunidade e adquira já sua bola!', 275.80, 'bolas', 56, '69c299bc60f96_1xg.jpg', 'ativo', '2026-03-24 14:03:40'),
(17, 'Bola de Basquete Spalding 3X3 TF-33 FIBA Microfibra #6', '• Bola oficial modalidade basquete 3X3, dentro da regulamentação FIBA para o 3x3\r\n• Bola tamanho 6 e peso 650g, mesmo peso de bolas tam. 6\r\n• Revestimento em microfibra de alta qualidade e grip\r\n• Bola aprovada pela Federação Internacional de Basquete (FIBA)\r\n• Selo \"FIBA APPROVED\" na bola\r\n• Câmara de ar 100% borracha butílica para excelente retenção de ar\r\n• Miolo removível e lubrificado.', 329.90, 'bolas', 35, '69c29adc0f7d7_bola_de_basquete_spalding_3x3_tf_33_fiba_microfibra_6_6875_2_daa44dc966184d3793168ac00550e268_20240515181428.webp', 'ativo', '2026-03-24 14:08:28'),
(18, 'Bola Basquete Wilson NBA Player Series Lebron James / Los Angeles Lakers', 'A Bola de Basquete NBA Player Icon Outdoor molda a vida dos melhores atletas do mundo e, em troca, eles evoluem o jogo com seu estilo, engenhosidade e criatividade. Celebrando o talento de cada jogador, eles são mais do que cores ou uma camisa, eles representam o que abre caminho no jogo de hoje. Os momentos cruciais que cada jogador cria na quadra ajudam a contar a história da nossa liga, pois cada um escreve seu próprio capítulo.', 430.80, 'bolas', 26, '69c29b280c52b_bola_basquete_wilson_nba_player_series_lebron_james_los_angeles_lakers_12657_1_ca3d051827619b8deb5c2e03e4970f78.webp', 'ativo', '2026-03-24 14:09:44'),
(19, 'Bola de Basquete Molten BG3800 T6-BR CBB Oficial Basketball FIBA Approved', 'Molten apresenta a Linha de Bolas Oficial do Basquete brasileiro e com FIBA Approved. Como uma das principais marcas de basquete em todo o mundo, a Molten continua a criar bolas de basquete de qualidade superior com tecnologias inovadoras.', 494.70, 'bolas', 18, '69c29b696e2c8_1739399589.jpeg', 'ativo', '2026-03-24 14:10:49'),
(20, 'Kit 3 Bolas de Basquete Molten BG5000 Basketball em Couro FIBA Approved T7', 'A Molten se dedica a fornecer bolas de basquete de primeira linha para a FIBA ​​e a comunidade global de basquete. Ao combinar tecnologia inovadora e habilidade superior, a Molten continua a criar produtos dignos de serem jogados pelas estrelas do basquete de elite do mundo.', 2420.50, 'bolas', 22, '69c29c067f4fe_1720058854.jpeg', 'ativo', '2026-03-24 14:13:26'),
(21, 'Bola de Basquete Molten EZ7', 'Seja no treino ou em competições, a Bola de Basquete Molten EZ7 foi projetada para oferecer a melhor experiência aos jogadores.', 370.75, 'bolas', 11, '69c29c4df1106_1420-pnc20w.webp', 'ativo', '2026-03-24 14:14:37'),
(22, 'Bola De Basquete Penalty 3x3 Pro', 'O basquete 3x3 ocorre com 6 jogadores em quadra, 3 em um time e 3 no outro. A bola da Liga Nacional de Basquete (NBB) e da Federação Paulista de Basketball (FPB). Essa bola de basquete foi desenvolvida pensando na melhor maneira de transformar as partidas em diversão e atrair mais atletas para a modalidade. Sua construção permite maior resistência e conforto durante os passes e arremessos. Por fim, seu design é composto pelas cores branca, preta e vermelha, além do logo estampado no centro da bola.', 299.99, 'bolas', 12, '69c29c91e5741_1505839-800-auto.png', 'ativo', '2026-03-24 14:15:45'),
(23, 'BOLA BASQUETE PENALTY BT7600 VIII', 'A bola de basquete modelo BT 7600 VIII Masculina, desenvolvida pela Penalty, é uma excelente opção para homens que buscam aperfeiçoar suas habilidades em quadra. O produto é confeccionado em microfibra de poliuretano, garantindo maior resistência e durabilidade.', 349.80, 'bolas', 32, '69c29cfdf02e0_870946-300-300.webp', 'ativo', '2026-03-24 14:17:33'),
(24, 'Bola Basquete Molten 3X3 Oficial', 'Como uma das principais marcas de basquete em todo o mundo, a Molten continua a criar bolas de basquete de qualidade superior com tecnologias inovadoras.', 369.90, 'bolas', 34, '69c29d5c870d5_bola_basquete_molten_3x3_oficial_2183_1_8d76c75d1ecdcce2806c20f9240f785d.webp', 'ativo', '2026-03-24 14:19:08'),
(25, 'Bola de Basquete Penalty 7.5', 'Produzida pela Penalty, a bola de basquete da linha 7.5 é aprovada pela Federação Internacional de Basquete-FIBA e traz tamanho masculino, sendo matrizada e feita em microfibra de poliuretano, ideal para homens que curtem jogos intensos e de qualidade.', 249.50, 'bolas', 49, '69c29da5aae06_bola_de_basquete_penalty_7_5_13172_1_20210806223052.webp', 'ativo', '2026-03-24 14:20:21'),
(26, 'Bola de Basquete Wilson Gamebreaker Tamanho 7 - Indoor/Outdoor', 'A Bola Wilson Gamebreaker é a solução definitiva para quem joga em qualquer lugar. Com construção híbrida de alta resistência, ela performa com excelência tanto no asfalto quanto no ginásio. Possui canais profundos para melhor controle e superfície de borracha granulada que garante um grip duradouro.', 139.90, 'bolas', 32, '69c29e4bf3e1d_whatsapp_image_2026-02-09_at_11.17.38.jpeg.png', 'ativo', '2026-03-24 14:23:07'),
(27, 'Bola De Basquete Wilson MVP Tam 7 Natural', 'A marca Wilson é reconhecida por seus equipamentos de alta qualidade para as mais diversas modalidades de esporte. A Bola De Basquete Wilson MVP Tam 7 Natural é fabricada em borracha de alta qualidade é uma excelente opção para você fazer bonito nas quadras.', 198.90, 'bolas', 27, '69c29e94a3e76_bola-de-basquete-wilson-mvp-tam-7-natural.jpg', 'ativo', '2026-03-24 14:24:20'),
(28, 'Regata NBA Retrô L.A Lakers #8 - Kobe Bryant - Amarela (Ed. Especial)', 'Nos tempos de colégio, Kobe Bryant usou a camisa número 24. Posteriormente, trocou para a 33 em homenagem ao pai. Porém, quando chegou aos Lakers, em 1996, nenhuma das duas estava disponível. A 33 é aposentada em homenagem a Kareem Abdul-Jabbar e a 24 estava sendo usada por George McCloud.', 550.90, 'regatas', 12, '69c3cecbbd383_kobe-31-09f0fbb3514ff8d9fe17418161292476-1024-1024.png', 'ativo', '2026-03-25 12:02:19'),
(29, 'Zoom na imagem Regata Brooklyn Nets City Edition 19/20 Biggie', 'A regata City Edition 2019/2020 do Brooklyn Nets é uma das mais icônicas da NBA porque homenageia o rapper\r\nThe Notorious B.I.G. (Biggie), que nasceu no bairro de Bedford-Stuyvesant (Brooklyn).', 279.99, 'regatas', 25, '69c3cf3ea7ed4_brooklyn-nets-city-kevin-durant-yellow-jersey.webp', 'ativo', '2026-03-25 12:04:14'),
(30, 'Regata Memphis Grizzlies Swingman Statement Edition 22/23 Azul Masculina', 'Abra caminho para o jogo com a Regata Masculina Memphis Grizzlies Swingman Statement Edition 22/23 Azul. Esta não é apenas uma vestimenta esportiva, é uma afirmação de apoio e identidade com a força e a determinação dos Grizzlies. O azul intenso desta edição faz eco ao espírito implacável do time, enquanto a qualidade premium do tecido oferece conforto superior durante toda a jornada.', 289.90, 'regatas', 10, '69c3cf8294b9e_jordan-regata-p-nao-personalizar-regata-memphis-grizzlies-swingman-statement-edition-22-23-azul-masculina-40862313382203_1000x.webp', 'ativo', '2026-03-25 12:05:22'),
(31, 'Regata NBA Los Angeles Lakers Association Edition Swingman Jersey LeBron James 6 Branca', 'Celebre a Grandeza com a Camisa NBA Los Angeles Lakers LeBron James 6 Branca!!\r\n\r\nSe você é fã do basquete e um admirador de LeBron James, não pode deixar de adicionar esta Camisa NBA Los Angeles Lakers Nike Association Edition Swingman Jersey à sua coleção. Com a lendária camisa branca dos Lakers e o número 6 de LeBron James, esta camisa é uma homenagem ao legado e à habilidade do jogador que conquistou o coração de fãs em todo o mundo.', 389.90, 'regatas', 37, '69c3d0c83b25c_camisa_nba_los_angeles_lakers_nike_association_edition_swingman_jersey_lebron_james_6_branca_2385_2_9918c9c232558683b8b3153f4b54e0e8.webp', 'ativo', '2026-03-25 12:10:48'),
(32, 'Regata Charlotte Hornets Swingman Classic Edition 23/24 Azul Masculina', 'A regata Classic Edition 2023/24 do Charlotte Hornets é uma peça retrô que resgata a identidade histórica da franquia, trazendo de volta o visual icônico dos anos 90 com um toque moderno.', 390.49, 'regatas', 16, '69c3d12fd7814_jordan-regata-p-nao-personalizar-regata-charlotte-hornets-swingman-classic-edition-23-24-azul-masculina-43424449003835.webp', 'ativo', '2026-03-25 12:12:31'),
(33, 'Regata Atlanta Hawks City Edition Diamante 75th', 'Linha especial lançada na temporada 2021/22\r\nCelebra os 75 anos da NBA (1946–2021)\r\nInclui o selo/patch comemorativo “diamond anniversary”\r\nUniformes com acabamento mais premium', 459.90, 'regatas', 8, '69c3d173e53b3_AtlantaHawksCityEditionDiamante75th.webp', 'ativo', '2026-03-25 12:13:39'),
(34, 'Regata San Antonio Spurs Swingman Statement Edition 22/23 Preta Masculina', 'Com base na camisa autêntica da NBA, essa edição Statement permite que você represente o seu time enquanto o mantêm fresco e confortável a cada passo.', 429.90, 'regatas', 32, '69c3d1e797874_jordan-regata-p-nao-personalizar-regata-san-antonio-spurs-swingman-statement-edition-22-23-preta-masculina-41298201575739_1000x.webp', 'ativo', '2026-03-25 12:15:35'),
(35, 'Regata Nba Golden State Warriors - Stephen Curry - 30', 'A regata City Edition 2024/2025 do Golden State Warriors, versão jogador Draymond Green #23, é uma peça moderna que representa a identidade cultural da cidade de San Francisco e a conexão histórica da franquia com a Bay Area.', 459.90, 'regatas', 32, '69c3d2d082e5a_D_NQ_NP_2X_740786-MLB106794623866_022026-T.webp', 'ativo', '2026-03-25 12:19:28'),
(36, 'Regata Nike Stephen Curry Masculina', 'Regata Nike NBA Golden State Warriors 2024/25 Select Series \"Stephen Curry\" Mostre seu apoio ao lendário jogador com a Regata Nike NBA Golden State Warriors 2024/25 Select Series \"Stephen Curry\". Desenhada para unir o amor pelo basquete e pelo estilo, esta regata é uma peça indispensável para os verdadeiros fãs. Com um design moderno e detalhes em preto que trazem uma vibe urbana, esta regata é fabricada com materiais de alta qualidade para garantir conforto e durabilidade. Seu ajuste regular oferece liberdade de movimento em qualquer situação, seja nos treinos ou nas ruas. Com o logo do jogador Stephen Curry em destaque, esta regata é uma celebração do esporte e do estilo de vida.', 529.90, 'regatas', 12, '69c3d30474514_FN590-7-053-2-800x1000.webp', 'ativo', '2026-03-25 12:20:20'),
(37, 'Camisa Regata NBA Unissex Anthony Edwards Jordan Brand Navy 2025 NBA All-Star Game Swingman', 'Você pode parecer que está pronto para amarrar os cadarços no NBA All-Star Game de 2025 com esta camisa Swingman. Esta camisa Jordan Brand Anthony Edwards é a regata swingman, com seus detalhes de equipe e evento aplicados com calor. A tecnologia Dri-FIT manterá você fresco e confortável para onde quer que seu dia o leve.', 569.90, 'regatas', 16, '69c3d3974f288_unisex-jordan-brand-anthony-edwards-navy-2025-nba-all-star-game-swingman-player-jersey_ss5_p-202796405_pv-1_u-5ymqht36vtukk6bkbxyp_v-vlc8znbdinmng2egfqyd.webp', 'ativo', '2026-03-25 12:22:47'),
(38, 'Camisa Regata NBA Unissex LeBron James Jordan Brand Light Blue 2025 NBA All-Star Game Swingman', 'Você pode parecer que está pronto para amarrar os cadarços no NBA All-Star Game de 2025 com esta camisa Swingman. Esta camisa Jordan Brand Lebron James é a regata swingman, com seus detalhes de equipe e evento aplicados com calor. A tecnologia Dri-FIT manterá você fresco e confortável para onde quer que seu dia o leve.', 629.90, 'regatas', 9, '69c3d3c654771_unisex-jordan-brand-lebron-james-light-blue-2025-nba-all-star-game-swingman-player-jersey_ss5_p-202796406_pv-1_u-fxybxiyf3qsgi4qybcsa_v-ferkwe7fkvuoougjybuw.webp', 'ativo', '2026-03-25 12:23:34'),
(39, 'Camisa Regata Basquete USA Branca Durant 7 2024/25', 'Vista-se com a Camisa Regata Basquete USA Branca Durant 7 2024/25 com valor promocional. Logo mais o destaque está a gola V com recorte reto frontal e logo mais as três listras em tamanho grande, aplicadas nas laterais do manto maneira colorida. Confira os detalhes da Camisa Regata Basquete USA Branca Durant 7 2024/25.', 579.80, 'regatas', 18, '69c3d3f97a45e_camisa_usa_basketball_2024_nike_swingman_jersey_unisex_kevin_durant_7_branca-1-1.webp', 'ativo', '2026-03-25 12:24:25'),
(40, 'Regata Basquete NBA All Star Embiid 21 Edição Jogador Silk', 'A regata All-Star Game do Joel Embiid (#21) é uma peça especial usada durante o evento mais estrelado da NBA, o All-Star Game, reunindo os melhores jogadores da liga em um uniforme exclusivo e estiloso.', 459.70, 'regatas', 45, '69c3d45287f26_26e6ad193b.webp', 'ativo', '2026-03-25 12:25:54'),
(41, 'Regata San Antonio Spurs Statement Edition 25/26', 'San Antonio Spurs é um time de basquete da National Basketball Association (NBA) localizado em San Antonio, Texas. As cores do uniforme são preto, prata e branco. A equipe foi fundada em 1967 como Dallas Chaparrals na American Basketball Association, mudando o nome para Texas Chaparrals entre 1970 e 1971, e ao se mudar para San Antonio em 1973 fora rebatizado San Antonio Gunslingers, mas antes mesmo de jogar, virou San Antonio Spurs.', 349.90, 'regatas', 35, '69c3d49e3fe50_spurswembanyamastatement.webp', 'ativo', '2026-03-25 12:27:10'),
(42, 'Regata Nike NBA Memphis Grizzies Hardwood Classics 2024/25 Masculina', 'Lembra quando você se apaixonou pelo Grizzlies? Recupere esse sentimento prestando uma homenagem ao que o Memphis Grizzlies usava antigamente com a coleção Hardwood Classics da Nike. Uma versão para quadra, esta camisa do Desmond Bane conta com mesh respirável e tecnologia Dri-FIT para ajudar a manter você fresco e seco.', 439.90, 'regatas', 25, '69c3d4e30ef27_03127651A1.jpg', 'ativo', '2026-03-25 12:28:19'),
(43, 'Regata NBA Nike Swingman - Brooklyn Nets Branca', 'A regata Nike Swingman branca do Brooklyn Nets (também chamada de Association Edition) é o modelo mais clássico da franquia, trazendo um visual limpo e tradicional da NBA.', 459.90, 'regatas', 37, '69c3d554a54fc_regata-nba-nike-swingman-brooklyn-nets-branca-irving-111-2e0b2228f9d135408715914044544703-1024-1024-d8309b29aa39d9dc5b17230385209579-480-0.webp', 'ativo', '2026-03-25 12:30:12'),
(44, 'Regata NBA Nike Swingman - Chicago Bulls Vermelha - Jordan #23', 'Para os amantes da NBA, a Camisa Regata Nike NBA  é a pedida certa. Confeccionada em materiais de qualidade oferece conforto e liberdade dos movimentos. ', 529.90, 'regatas', 10, '69c3d59313260_regata-nba-nike-swingman-chicago-bulls-vermelha-jordan-231-0aa70c36158429c15615914100592474-640-0.webp', 'ativo', '2026-03-25 12:31:15'),
(45, 'Milwaukee Bucks City Edition 75º NBA 21/22 - Masculina', 'A temporada que começou em 2021 foi muito especial pra liga norte-americana de basquete. Isso porque ela não é uma data qualquer, é a NBA 75 anos!\r\nIsso mesmo, são 75 anos de jogos incríveis, lendas sendo forjadas e nomes que marcaram gerações nesse esporte apaixonante e enlouquecedor.', 439.90, 'regatas', 31, '69c3d62b5b261_d7dae9a2-removebg-preview1-b1964a34cae051a7d716796183018044-480-0.webp', 'ativo', '2026-03-25 12:33:47'),
(46, 'Camiseta Regata Toronto Raptors 95 NBA Vince Carter #15', 'A regata Toronto Raptors “95” Vince Carter #15 é um dos modelos mais icônicos da NBA, inspirada na fase inicial da franquia nos anos 90 e eternizada por Vince Carter.', 649.90, 'regatas', 11, '69c3d6c391064_52ed5325f52c2e99fe2ed156df36fa03.jpeg', 'ativo', '2026-03-25 12:36:19'),
(47, 'Regata NBA Los Angeles Lakers Statement Edition Swingman Jersey Luka Doncic 77 Roxa', 'A regata Statement Edition do Los Angeles Lakers, versão Luka Dončić #77, é uma das mais modernas da NBA, combinando o visual tradicional da franquia com um design mais ousado e esportivo.', 459.90, 'regatas', 34, '69c3d73018849_regata_nba_los_angeles_lakers_statement_edition_sw_1_20251229151848_675c1f7231e5.webp', 'ativo', '2026-03-25 12:38:08'),
(48, 'KD 17', 'O status de Kevin Durant como rei da bola é difícil de abalar, mas ele ainda precisa praticar suas habilidades na quadra para satisfazer sua alma do basquete. Trabalhe duro para ser excelente com o tênis de basquete masculino KD17 EP, projetado para entusiastas do fitness e jogadores persistentes. O amortecimento Air Zoom no antepé torna o seu início mais poderoso. Combinado com o amortecimento Nike Air, fornece potência para os sprints decisivos e paradas defensivas. A sola de borracha durável desta versão oferece tração superior.', 990.90, 'tenis', 21, '69c3d7fabb883_FJ9488-101_BL1.webp', 'ativo', '2026-03-25 12:41:30'),
(49, 'Tênis de Basquete Under Armour Curry 3Z7 Masculino Original', 'O cabedal em malha garante mais respirabilidade e mobilidade, enquanto as peças em couro localizadas na biqueira, vista e lateral proporcionam segurança e durabilidade.', 789.90, 'tenis', 20, '69c3d858a8991_under-armour-curry-7782-3745-6d6682619f6bcb8c4e90cd36b7c8c20f.jpg', 'ativo', '2026-03-25 12:43:04'),
(50, 'Tênis de Basquete Under Armour Curry 12 Extraterrestrial', 'O Tênis de Basquete Under Armour Curry 12 Extraterrestrial, possui a parte superior em malha respirável proporciona maior conforto e controle durante movimentos dinâmicos.', 1199.90, 'tenis', 10, '69c3d88ddee75_3027633-001-01.webp', 'ativo', '2026-03-25 12:43:57'),
(51, 'Tênis de Basquete Masculino Under Armour Curry 2 Low Flotro', 'O Under Armour Curry 2 Low FloTro é uma versão moderna de um dos tênis mais clássicos do Stephen Curry, combinando o design retrô do Curry 2 com a tecnologia atual da linha FloTro.', 799.90, 'tenis', 30, '6a0b545cccb85_412476-800-auto.webp', 'ativo', '2026-03-25 12:45:08'),
(52, 'Tênis de Basquete Masculino Under Armour Curry 10 Dub Nation', 'O Under Armour Curry 10 Dub Nation é um dos modelos mais tecnológicos da linha do Stephen Curry, criado para jogadores rápidos e que valorizam controle total em quadra.', 1099.90, 'tenis', 26, '69c3d911105b8_3026949-400-01.webp', 'ativo', '2026-03-25 12:46:09'),
(53, 'ênis Basquete Anthony Edwards 1 The Future', 'O AE1 “The Future” é o primeiro tênis assinatura do Anthony Edwards, estrela do Minnesota Timberwolves, e rapidamente virou um dos modelos mais comentados da NBA.', 1399.90, 'tenis', 21, '69c3da5475bca_Tenis_Basquete_Anthony_Edwards_1_The_Future_Preto_IF1858_01_standard.avif', 'ativo', '2026-03-25 12:51:32'),
(54, 'AE 2 Anthony Edwards', 'Comemore uma das estrelas em ascensão do esporte com os mais recentes tênis exclusivos da adidas Basketball e Anthony Edwards. Estes tênis de basquete de alto desempenho oferecem suporte à ação de alta velocidade e voo que fez de Edwards um astro internacional. Combinando o retorno de energia do BOOST e o amortecimento ultraleve do Lightstrike, estes tênis foram projetados para jogadores que dominam com sua velocidade e capacidade atlética. Os logotipos da Anthony Edwards completam o visual exclusivo.', 1249.90, 'tenis', 4, '69c3da92afd16_10-4_AdidasAnthonyEdwards2_AE2_WithLove_20_900_JS3514_AE2_AnthonyEdwards2_1.webp', 'ativo', '2026-03-25 12:52:34'),
(55, 'Tênis Anthony Edwards 1 Low adidas', 'O adidas AE1 Low é a versão de cano baixo do primeiro tênis assinatura do Anthony Edwards, trazendo mais liberdade de movimento e leveza em quadra.', 1190.90, 'tenis', 11, '69c3dae235218_D_NQ_NP_785837-MLB89758065762_082025-O-tnis-anthony-edwards-1-low-adidas.webp', 'ativo', '2026-03-25 12:53:54'),
(56, 'Tênis Nike Jordan Luka 2 S - Masculino', 'Cuidadosamente construído, o design desse tênis tem elementos inspirados na Eslovênia, país natal de Luka Doncic,estrela do basquete, atleta do time Dallas Mavericks e parceiro da Nike nesta belíssima edição do Jordan.\r\n\r\nSua estrutura é projetada para os grandes saltos e aterrissagens, e o solado te dá segurança nos 48 minutos, elevando seu desempenho ao máximo e proporcionando uma experiência única em quadra.', 999.90, 'tenis', 13, '69c3db257f862_985023JUA9.jpg', 'ativo', '2026-03-25 12:55:01'),
(57, 'Tênis Jordan Luka 2 Masculino', 'O Jordan Luka 2 é o segundo tênis assinatura do Luka Dončić, desenvolvido especialmente para jogadores que usam muito step-back, mudança de direção e controle de jogo.', 899.90, 'tenis', 30, '69c3db8b163ba_477673-800-auto.webp', 'ativo', '2026-03-25 12:56:43'),
(58, 'Tênis Lebron XX', 'Bah, farsa! Não com o LeBron 20 “Stocking Stuffer” debaixo da árvore. Revisitando a linha icônica dos tênis de Natal do rei, a variedade festiva de gráficos e cores deste design cria uma mistura do passado do Natal. De centavos a dunks, este não é um suéter feio - seu design leve, rente ao chão e ultra-almofadado é mais fresco que pinho e mais aconchegante que uma xícara de chocolate ao lado da lareira. Espero que você tenha sido legal esse ano.', 1299.90, 'tenis', 11, '69c3dbc212cc0_025444NX.avif', 'ativo', '2026-03-25 12:57:38'),
(59, 'Tênis Nike Lebron XXII Masculino', 'O Nike LeBron XXII é a evolução mais recente da linha do LeBron James, feito para jogadores que combinam força, explosão e velocidade. É um tênis pensado para desempenho de alto nível — especialmente para quem joga com intensidade física.', 1399.90, 'tenis', 21, '69c3dc03a0b48_HV845-4-001-1-AW-800X1000.webp', 'ativo', '2026-03-25 12:58:43'),
(60, 'Tênis Nike Kobe 6 Protro “Grinch”', 'O Kobe “Grinch” é simplesmente um dos tênis mais lendários do basquete. Ele ficou famoso quando Kobe Bryant usou no jogo de Natal de 2010 — e virou um clássico instantâneo. O apelido “Grinch” vem justamente da aparência parecida com o personagem natalino verde.', 2199.90, 'tenis', 3, '69c3dc7b2afdf_sg-11134201-7rcep-lto9129es6o32b.jpeg', 'ativo', '2026-03-25 13:00:43'),
(61, 'Kobe 8 Protro', 'Kobe é o único jogador na história da NBA a ter dois números aposentados no mesmo time. Este Kobe 8 Protro celebra seu feito incomparável em uma colorway Radiant Emerald e White inspirada nas férias da família Bryant em Bora Bora. A malha leve e arejada na parte superior e uma placa arqueada no meio do pé acrescentam conforto, suporte e estabilidade que tornam este ícone um pilar em todos os níveis de jogo. O design é finalizado com o logotipo “Sheath” de Kobe (em um tom Radiant Emerald) e ambos os números retirados, honrando sua mentalidade lendária e legado contínuo.', 1179.90, 'tenis', 12, '69c3e42177c47_02840851A8.avif', 'ativo', '2026-03-25 13:33:21'),
(62, 'Nike Kyrie 7 \"Daughters\"', ' Inspirado no estilo Kyrie Irving dentro e fora das quadras, o Tênis Nike Kyrie 7 é a escolha certa para estar bem preparado diante de qualquer desafio. De cano médio para um melhor suporte, o tênis de basquete Kyrie apresenta cabedal (parte superior do tênis) têxtil com o “swoosh” lateral que confere o padrão Nike de qualidade. Na entressola do Nike Kyrie 7, a diferenciada tecnologia Air Zoom Turbo agrega flexibilidade multidirecional com amortecimento reativo para curvas rápidas e ágeis. Já seu solado permite excelente tração para total controle durante cada lance do jogo com o logo personalizado do astro do basquete bordado no contraforte traseiro. ', 899.90, 'tenis', 23, '69c3e46acf51a_FOTODOPRODUTO_5.webp', 'ativo', '2026-03-25 13:34:34'),
(63, 'Spongebob x Nike Kyrie 5 Squarepants', 'O Nike Kyrie 5 Spongebob Squarepants faz parte de uma coleção temática feita pela Nike com a Nickelodeon da famosa série de televisão “Bob Esponja: Calça Quadrada”. A coleção consiste em três modelos Kyrie 5 e dois Kyrie Low 2s.', 2199.90, 'tenis', 5, '69c3e4c9c6710_20240922233950563-655.webp', 'ativo', '2026-03-25 13:36:09'),
(64, 'Tênis Puma MB.04 Iridescent Hornets - Pink+Azul', 'Com design inspirado nas cores do Charlotte Hornets e detalhes iridescentes que mudam conforme a luz, este modelo é puro espetáculo. Conta com a tecnologia NITROFOAM para desempenho incomparável e um cabedal reforçado em mesh técnico. Voltado para jogadores criativos e ousados, que querem impactar com estilo e habilidade. Faça cada jogo brilhar com sua presença.', 1099.90, 'tenis', 19, '69c3e56776d99_PI3-6129-411_zoom1.webp', 'ativo', '2026-03-25 13:38:47'),
(65, 'Tênis Puma MB.03 Toxic PS', 'O Puma MB.03 Toxic PS é a versão infantil (PS = Pre-School) do terceiro tênis assinatura do LaMelo Ball, trazendo o mesmo visual “alienígena” e tecnologias do modelo adulto, adaptado para crianças.', 1079.90, 'tenis', 43, '69c3e5abf2e24_39372-5-001-1.webp', 'ativo', '2026-03-25 13:39:55'),
(66, 'Tênis Harden 8', 'Só desafiar as regras não é suficiente para um craque como James Harden; é necessário revolucionar o jogo. O mais novo tênis assinado pela adidas Basketball com James Harden continua homenageando um dos cestinhas de elite do basquete. Exibindo a combinação das entressolas adidas BOOST e Lightstrike, este tênis de basquete de alto desempenho oferece todo o suporte necessário para dominar as quadras.', 990.90, 'tenis', 42, '69c3e60679833_21_cm_1.webp', 'ativo', '2026-03-25 13:41:26'),
(67, 'Tênis Harden Volume 9', 'O adidas Harden Vol. 9 é a evolução da linha do James Harden, feito para jogadores que usam muito drible, step-back e mudança de ritmo. É um tênis pensado para controle total do jogo — bem no estilo do Harden.', 979.90, 'tenis', 18, '69c3e64648d3a_Tenis_Harden_Volume_9_Prata_JR2506_01_00_standard.avif', 'ativo', '2026-03-25 13:42:30'),
(68, 'Chinelo Masculino Slide Conforto Rider Basquete NBA II - Preto+Azul', 'Entre em quadra com estilo e confiança com o Chinelo Gáspea Rider de Basquete NBA II. Este não é apenas um chinelo; é uma declaração de paixão pelo basquete e pelo mundo NBA, combinando conforto excepcional e design autêntico. Criado pela renomada marca Rider, o modelo NBA II é uma celebração do esporte e da cultura do basquete, trazendo a essência da NBA para seus pés. O Rider Pump NBA II Slide é um slide licenciado NBA com sola em PVC expandido, palmilha em EVA conformada inspirada nos calçados esportivos com volumetria que proporciona conforto. Possui gáspea em coverline com serigrafia e frequência, além de forro em corte a fio costurado na gáspea. Seu jogo de cores proporciona modernidade e esportividade, tendo como inspiração os principais times da NBA.', 109.90, 'chinelo', 21, '69e67ca26eaaf_G71-2889-118_zoom1.webp', 'ativo', '2026-04-20 19:21:06'),
(69, 'Chinelo Slide Masculino Rider Pump NBA Basquete Confortável', 'O Rider Pump NBA Slide é um slide licenciado NBA com sola em PVC expandido, palmilha em EVA conformada inspirada nos calçados esportivos com volumetria que proporciona conforto. Possui gáspea em coverline com serigrafia e frequência, além de forro em corte a fio costurado na gáspea.', 98.70, 'chinelo', 10, '69e67d3b5effb_sg-11134201-7rbmm-lo8pu74kw78wed.jpg', 'ativo', '2026-04-20 19:23:39'),
(70, 'Chinelo Masculino Slide Conforto Rider Basquete NBA II - Azul+Vermelho', ' O Rider Pump NBA II Slide é um slide licenciado NBA com sola em PVC expandido, palmilha em EVA conformada inspirada nos calçados esportivos com volumetria que proporciona conforto. Possui gáspea em coverline com serigrafia e frequência, além de forro em corte a fio costurado na gáspea. Seu jogo de cores proporciona modernidade e esportividade, tendo como inspiração os principais times da NBA.', 75.90, 'chinelo', 32, '69e67d95110ef_G71-2889-066_zoom1.webp', 'ativo', '2026-04-20 19:25:09'),
(71, 'Crocs NBA Echo Slide', 'A união entre Crocs e NBA deu origem a uma colaboração revolucionária que vai além dos calçados comuns. Saiba como essa parceria produziu o incrível Crocs NBA Echo Slide, um chinelo que une conforto, estilo e uma dose extra de personalidade para os amantes da moda e do basquete.', 230.90, 'chinelo', 12, '6a0c98bc059a6_ipad_crocs-nba-echo-slide-sienna-0.png', 'ativo', '2026-05-19 16:20:35'),
(72, 'Chinelo Nike Air UpTempo Slide Cadarço Vermelho', 'Construa essa ponte entre moda e função com os slides Air More Uptempo. Arejados e leves, eles oferecem um grande sabor fora da quadra inspirado em um dos seus tênis de basquete favoritos dos anos 90.', 199.90, 'chinelo', 21, '6a0c9837998d0_S63ba48e721c546b7a8cd97779955d345x_9c7f46ad-9474-4d15-a33e-6646acec4542-Photoroom.png-Photoroom.webp', 'ativo', '2026-05-19 17:04:55'),
(73, 'Chinelo Rider Full 86 NBA Slide AD Masculino 11505', 'O Chinelo Slide Rider Full 86 Nba 11505 é um slide da Rider com tema NBA, bem na linha “casual confortável + visual esportivo retrô”.', 129.90, 'chinelo', 32, '6a0c99706aa2b_13310760743_115052567500-5.png', 'ativo', '2026-05-19 17:10:08'),
(74, 'Chinelo Nike Air Jordan Bege', 'O chinelo Air Jordan combina a facilidade e o conforto de um slide com o design arrojado do icônico Air Jordan. Além de ser muito leve proporcionando conforto sem igual para o seus pés', 179.90, 'chinelo', 14, '6a0c99d3c18b6_d3f1df81357a12e914e4333db70993d7.webp', 'ativo', '2026-05-19 17:11:47'),
(75, 'Chinelo Slide NBA Grendene Rider Pump II - Adulto', 'Pise macio no conforto de um Grendene Rider Pump demonstrando seu favoritismo pelo time preferido. Perfeito para relaxar os pés depois dos treinos ou mesmo dia a dia, o Chinelo Slide NBA possui tira larga em sintético com o escudo do time, palmilha texturizada e macia de formato anatômico e solado em EVA.\r\n', 68.90, 'chinelo', 23, '6a0c9e68e22d1_98212034A7.avif', 'ativo', '2026-05-19 17:31:20'),
(76, 'Chinelo Slide Rider Rush Nba 12512 Basquete 2025', 'Chinelo Slide Rider Masculino Rush NBA 12512\r\nO Rush NBA Slide leva todo o estilo e conforto do modelo original para a vibe da NBA! Com palmilha anatômica e texturas massageadoras, ele garante aquele ajuste perfeito nos pés. A sola de EVA traz leveza para o dia a dia, enquanto a gáspea estampa os principais times da liga.', 89.90, 'chinelo', 19, '6a0c9ede183f2_D_NQ_NP_994407-MLB87393283398_072025-O-chinelo-slide-rider-rush-nba-12512-basquete-2025.webp', 'ativo', '2026-05-19 17:33:18'),
(77, 'Chinelo Masculino Slide Conforto Rider Basquete NBA II', 'Entre em quadra com estilo e confiança com o Chinelo Gáspea Rider de Basquete NBA II. Este não é apenas um chinelo; é uma declaração de paixão pelo basquete e pelo mundo NBA, combinando conforto excepcional e design autêntico. Criado pela renomada marca Rider, o modelo NBA II é uma celebração do esporte e da cultura do basquete, trazendo a essência da NBA para seus pés.', 79.90, 'chinelo', 8, '6a0c9f3e26d5c_f0bf1cda750f6f600bc3cef26a55cef1.webp', 'ativo', '2026-05-19 17:34:54');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cupons`
--
ALTER TABLE `cupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cupons`
--
ALTER TABLE `cupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
