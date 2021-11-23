% Preliminaries
\NeedsTeXFormat{LaTeX2e}
\ProvidesClass{amari}[2019/04/26 Amari document class]
\LoadClass[oneside,12pt]{book}
\RequirePackage{xcolor}
\RequirePackage[utf8]{inputenc}
\usepackage[T1]{fontenc}
\RequirePackage{tikz}
\RequirePackage{nopageno}
\RequirePackage{setspace}
\RequirePackage{fontspec}
\RequirePackage[explicit]{titlesec}
\usetikzlibrary{calc}

% Colors
\definecolor{AmariAmber}{HTML}{4F3527}
\definecolor{AmariGreen}{HTML}{524E11}
\definecolor{AmariBlue}{HTML}{4F7282}
\definecolor{AmariTeal}{HTML}{4B5B5F}
\definecolor{AmariGray}{HTML}{686D70}
\definecolor{AmariBeaver}{HTML}{56514D}
\definecolor{AmariUltramarine}{HTML}{292B37}
\definecolor{AmariBackground}{HTML}{2E3436}
\definecolor{AmariText}{HTML}{D3D7CF}

\pgfmathdeclarerandomlist{AmariRandomColours}{%
    {AmariAmber}{AmariGreen}{AmariBlue}{AmariTeal}{AmariGray}{AmariBeaver}{AmariUltramarine}
}

% Styling
\setlength\paperheight {250mm}
\setlength\paperwidth {300mm}
\setlength\textheight {220mm}
\setlength\textwidth {210mm}
\setlength\hoffset {-1in}
\setlength\voffset {-1in}
\setlength\oddsidemargin {10mm}
\setlength\parindent {0pt}
\setlength\topmargin {10mm}
\setlength\headheight {0mm}
\setlength\marginparsep {10mm}
\setlength\marginparwidth {60mm}
\setlength\headsep {0mm}
\pagecolor{AmariBackground}
\color{AmariText}
\linespread{1.5}
\newfontfamily{\ComicRelief}{ComicRelief}
[Extension = .ttf]

\titleformat{\part}
  {\ComicRelief\Huge}
  {{\thepart\ }}
  {0pt}
  {#1}
  [\titleline{\color{AmariAmber}\titlerule[3pt]}]

\titleformat{\chapter}
  {\ComicRelief\huge}
  {{\thechapter\ }}
  {0pt}
  {#1}
  [\titleline{\color{AmariGreen}\titlerule[3pt]}]
\titlespacing*{\chapter}{0pt}{-30pt}{10pt}

\titleformat{\section}
  {\ComicRelief\LARGE}
  {{\thesection\ }}
  {0pt}
  {#1}
  [\titleline{\color{AmariBlue}\titlerule[3pt]}]

\titleformat{\subsection}
  {\ComicRelief\Large}
  {{\thesubsection\ }}
  {0pt}
  {#1}
  [\titleline{\color{AmariTeal}\titlerule[3pt]}]

\titleformat{\subsubsection}
  {\ComicRelief\large}
  {{\thesubsubsection\ }}
  {0pt}
  {#1}
  [\titleline{\color{AmariGray}\titlerule[3pt]}]

\titleformat{\paragraph}
  {\ComicRelief}
  {{\theparagraph\ }}
  {0pt}
  {#1}
  [\titleline{\color{AmariBeaver}\titlerule[3pt]}]

\titleformat{\subparagraph}
  {\ComicRelief\small}
  {{\thesubparagraph\ }}
  {0pt}
  {#1}
  [\titleline{\color{AmariUltramarine}\titlerule[3pt]}]

% Commands
\newcommand{\AmariRound}[4][]{
  \tikz\node [circle, minimum width = #2,
    path picture = {
      \node [#1] at (path picture bounding box.center) {
		\IfFileExists{./logo.png}{\includegraphics[width=#3]{#4}}{}};
    }] {};}

\newcommand{\AmariMargin}[1]{%
\pgfmathrandomitem{\RandomColor}{AmariRandomColours}
\setlength\fboxsep{6pt}
\marginpar{\fcolorbox{AmariText}{\RandomColor}{\parbox{\marginparwidth}{%
  \setstretch{0.7}\textcolor{AmariText}{\ComicRelief\footnotesize{#1}}}}}
\setlength\fboxsep{0pt} 
}

\renewcommand*{\maketitle}{
\begin{titlepage}
\centering{\AmariRound{5cm}{5cm}{logo}

\vspace{1cm}
\ComicRelief\huge\@author
\vspace{5mm}

\ComicRelief\large presents

\vspace{3cm}
\ComicRelief\Huge\@title

\vspace{3cm}
\ComicRelief\Large\@date}
\vfill

\end{titlepage}
}
