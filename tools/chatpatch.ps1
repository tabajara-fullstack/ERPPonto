param(
  [switch]$push,
  [string]$m = "update: apply patch from chat",
  [string]$f = ""
)
$ErrorActionPreference = "Stop"
function Ensure-Git { if (-not (Get-Command git -ErrorAction SilentlyContinue)) { throw "git não encontrado." } }
function Ensure-Repo { try { git rev-parse --is-inside-work-tree | Out-Null } catch { throw "Não é repo git." } }
Ensure-Git; Ensure-Repo
$patchfile = New-TemporaryFile
if ($f -ne "") {
  Copy-Item -Path $f -Destination $patchfile -Force
} else {
  try { $clip = Get-Clipboard -Raw } catch { throw "Clipboard vazio e nenhum arquivo (-f) informado." }
  $clip = $clip -replace "`r",""
  $clip | Set-Content -Path "$env:TEMP\clip.md" -Encoding UTF8
  $content = Get-Content "$env:TEMP\clip.md" -Raw
  $regex = [regex]'```(patch|diff)\s+(.*?)```'
  $matches = $regex.Matches($content)
  if ($matches.Count -eq 0) { throw "Nenhum bloco ```patch ou ```diff encontrado." }
  $all = ""
  foreach ($mch in $matches) { $all += $mch.Groups[2].Value + "`n`n" }
  $all | Set-Content -Path $patchfile -Encoding UTF8
}
Write-Host ">>> git apply -p0"
$applied=$true
try { git apply -p0 --whitespace=nowarn $patchfile } catch { Write-Host ">>> git apply -p1"; try { git apply -p1 --whitespace=nowarn $patchfile } catch { $applied=$false } }
if (-not $applied) { throw "Falha ao aplicar o patch." }
git add -A
$diff = git diff --cached --name-only
if (-not $diff) { Write-Host "Nada para commitar." } else { git commit -m $m }
if ($push) { try { git pull --rebase } catch {}; git push; Write-Host "✓ Push concluído." } else { Write-Host "✓ Commit local feito." }
