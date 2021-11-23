## あまり LaTeX
あまり LaTeX (*amari latekh*) is a collection of LaTeX config files used to make disctinctive documents.

Currently the section consists of:

1. あまり Document Class (`latex.zip`) – my very own, very private, very published under the MIT license LaTeX document class, which I use for many occasions, including this very specific situation when you want to have a presentation AND a script, which you can later publish on your website. Tested on XeLaTeX and it probably wouldn't work on any other LaTeX distribution. To make it work, download the package and use the document form in `example.txt` file. The necessary files to make it work are: `amari.cls` (document class file) and `ComicRelief.ttf` (font used for headers).

2. あまり Beamer Theme (`beamer.zip`) – `beamercolorthemeamari.sty` file contains beamer colour theme, use it like a regular color theme (`\usecolortheme[accent=<accent_colour>,<mode>]{amari}`). There are two *modes* available: *kaigijitsu* (dark theme) and *kyoukai* (light theme). There are also seven *accent colours*: Amber, Green, Blue, Teal, Gray, Beaver, Ultramarine. For more information please visit [あまり カラーズ](/okucha/amari/colors.proj). There is also a full-fledged beamer theme, the example of usage is included in the package. *Modes* and *accent colours* are the same.
