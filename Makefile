prerelease:
	git pull origin main --tag
	ghch -w -N ${VER}
	git add CHANGELOG.md
	git commit -m'Bump up version number'
	git tag ${VER}
	git tag -f v0

release:
	git push origin main --tag -f
