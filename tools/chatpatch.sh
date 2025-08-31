#!/usr/bin/env bash
# chatpatch.sh — Aplica patch do clipboard ao repositório git atual.
set -euo pipefail
msg="update: apply patch from chat"
do_push=0
from_file=""
while [[ $# -gt 0 ]]; do
  case "$1" in
    --push) do_push=1; shift ;;
    -m|--message) msg="$2"; shift 2 ;;
    -f|--file) from_file="$2"; shift 2 ;;
    -h|--help) echo "Uso: $0 [--push] [-m 'mensagem'] [-f arquivo.patch]"; exit 0 ;;
    *) echo "Opção desconhecida: $1" >&2; exit 1 ;;
  esac
done
if ! command -v git >/dev/null 2>&1; then echo "git não encontrado." >&2; exit 1; fi
if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then echo "Não é repo git." >&2; exit 1; fi
tmpdir="$(mktemp -d)"; trap 'rm -rf "$tmpdir"' EXIT
patchfile="$tmpdir/changes.patch"
if [[ -n "$from_file" ]]; then
  cp "$from_file" "$patchfile"
else
  get_clip() {
    if command -v pbpaste >/dev/null 2>&1; then pbpaste
    elif command -v xclip >/dev/null 2>&1; then xclip -o -selection clipboard
    elif command -v xsel >/dev/null 2>&1; then xsel --clipboard --output
    elif command -v wl-paste >/dev/null 2>&1; then wl-paste
    else echo ""; fi
  }
  CONTENT="$(get_clip)"
  if [[ -z "$CONTENT" ]]; then echo "Clipboard vazio e nenhum arquivo (-f) informado."; exit 1; fi
  printf "%s" "$CONTENT" | tr -d '\r' > "$tmpdir/clip.md"
  awk 'BEGIN{inblock=0} /```(patch|diff)/{inblock=1; next} /```/{if(inblock){inblock=0; print ""} next} {if(inblock) print}' "$tmpdir/clip.md" > "$patchfile"
fi
if [[ ! -s "$patchfile" ]]; then echo "Nenhum bloco ```patch ou ```diff encontrado."; exit 1; fi
echo ">>> git apply -p0"; set +e; git apply -p0 --whitespace=nowarn "$patchfile"; st=$?; set -e
if [[ $st -ne 0 ]]; then echo ">>> git apply -p1"; git apply -p1 --whitespace=nowarn "$patchfile"; fi
git add -A
if git diff --cached --quiet; then echo "Nada para commitar."; else git commit -m "$msg"; fi
if [[ $do_push -eq 1 ]]; then set +e; git pull --rebase; set -e; git push; echo "✓ Push concluído."; else echo "✓ Commit local feito."; fi
