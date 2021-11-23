RESOURCEDIR = "resources"
TARGETDIR = "build"
SOURCEDIR = "content"
INDEX = "templates/index.html"

SOURCES = $(shell find $(SOURCEDIR) -iname "*.md" -o -iname "*.rss")
SOURCESwithRSS = $(patsubst %.rss,build/%.xml,$(SOURCES))
HTMLs = $(patsubst %.md,build/%.html,$(SOURCESwithRSS))
TEMPFILE = build/sdfgsdfs7fs8d7tfgsduifgsdi5234j

all: mkdir index copy_resources $(HTMLs)

mkdir:
	mkdir -p $(TARGETDIR)
	find $(SOURCEDIR) -type d | cpio -pd $(TARGETDIR)
	find $(SOURCEDIR) -name '*.pdf' -o -name '*.tar.gz' -o -name '*.zip' -o -name '*.apk' | cpio -pdm $(TARGETDIR)

index:
	cp $(INDEX) $(TARGETDIR)

copy_resources:
	cp -r $(RESOURCEDIR) $(TARGETDIR)

build/%.html: %.md
	cat $< > $(TEMPFILE)
	panrun $(TEMPFILE) -s --katex -t html5 -o $@
	rm -f $(TEMPFILE)

build/%.xml: %.rss
	cat $< > $(TEMPFILE)
	panrun $(TEMPFILE) -f markdown -s --katex -t html5 -o $@
	rm -f $(TEMPFILE)

clean: 
	rm -rf $(TARGETDIR)
