--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `pseudo_id` int(11) NOT NULL,
  `commentaire` varchar(2000) NOT NULL,
  `date_add` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `core`
--

CREATE TABLE `core` (
  `id` int(11) NOT NULL,
  `maintenance` int(1) NOT NULL,
  `inscription` int(1) NOT NULL,
  `commentaires` int(1) NOT NULL,
  `news` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `core`
--

INSERT INTO `core` (`id`, `maintenance`, `inscription`, `commentaires`, `news`) VALUES
(1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `date_add` varchar(255) NOT NULL,
  `uploader_id` int(11) NOT NULL,
  `url_jaquette` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `titre_release` varchar(255) NOT NULL,
  `duree` varchar(255) NOT NULL,
  `date_sortie` varchar(255) NOT NULL,
  `realisateur` varchar(255) NOT NULL,
  `acteurs` varchar(255) NOT NULL,
  `genre_1` varchar(255) NOT NULL,
  `genre_2` varchar(255) NOT NULL DEFAULT '',
  `genre_3` varchar(255) NOT NULL DEFAULT '',
  `qualite` varchar(255) NOT NULL,
  `synopsy` varchar(2000) NOT NULL,
  `hebergeur_video` varchar(255) NOT NULL,
  `lien_streaming` varchar(255) NOT NULL,
  `exclusivite` int(1) NOT NULL DEFAULT '0',
  `video_hs` int(1) NOT NULL DEFAULT '0',
  `pending` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `genres`
--

INSERT INTO `genres` (`id`, `titre`) VALUES
(1, 'Action'),
(2, 'Animation'),
(3, 'Arts Martiaux'),
(4, 'Aventure'),
(5, 'Biopic'),
(6, 'Bollywood'),
(7, 'Classique'),
(8, 'Com&eacute;die'),
(9, 'Dessin anim&eacute;'),
(10, 'Documentaire'),
(11, 'Drame'),
(12, 'Epouvante-horreur'),
(13, 'Famille'),
(14, 'Fantastique'),
(15, 'Guerre'),
(16, 'Historique'),
(17, 'P&eacute;plum'),
(18, 'Policier'),
(19, 'Romance'),
(20, 'Science fiction'),
(21, 'Thriller'),
(22, 'Espionnage'),
(23, 'Western'),
(24, 'Musical'),
(25, 'Com&eacute;die dramatique');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '1',
  `cle` varchar(255) NOT NULL,
  `actif` int(1) NOT NULL DEFAULT '0',
  `renvoi_mdp` int(11) NOT NULL DEFAULT '0',
  `url_avatar` varchar(1000) DEFAULT NULL,
  `theme` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `password`, `email`, `ip`, `date`, `rank`, `cle`, `actif`, `renvoi_mdp`, `url_avatar`, `theme`) VALUES
(1, 'demo', '89e495e7941cf9e40e6980d14a16bf023ccd4c91', 'test@gmail.com', '127.0.0.1', '2016-05-14 10:05:09', 4, '1cc1570785198d3f522c7ec8047ce1e2', 1, 0, '', 9);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `pseudo_id` int(11) NOT NULL,
  `news` varchar(2000) NOT NULL,
  `date_add` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `qualiter`
--

CREATE TABLE `qualiter` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `qualiter`
--

INSERT INTO `qualiter` (`id`, `titre`) VALUES
(1, 'BRRiP'),
(2, 'BDRiP'),
(3, 'DVDRiP'),
(4, 'WEB-DL'),
(5, 'HDTV'),
(6, 'PDTV'),
(7, 'TVRiP'),
(8, 'R5|R6'),
(9, 'DVDscr'),
(10, 'WP'),
(11, 'SCR'),
(12, 'TC'),
(13, 'TS'),
(14, 'CAM'),
(15, 'VHSRiP'),
(16, 'HD 1080'),
(18, 'HD 720'),
(19, 'HDRiP'),
(20, 'WEBRiP'),
(21, 'HDTC');

-- --------------------------------------------------------

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `core`
--
ALTER TABLE `core`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `qualiter`
--
ALTER TABLE `qualiter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT pour la table `qualiter`
--
ALTER TABLE `qualiter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;