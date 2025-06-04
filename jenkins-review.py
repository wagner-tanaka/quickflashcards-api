import subprocess
import json

print("🔍 Buscando linhas adicionadas...")

subprocess.run("git config --global credential.helper store", shell=True, check=True)
subprocess.run("git fetch origin main:main", shell=True, check=True)

diff_cmd = "git diff main...HEAD --unified=0"
diff = subprocess.check_output(diff_cmd, shell=True, text=True)

lines = []
current_file = ""
current_line = 0

for line in diff.splitlines():
    if line.startswith("+++ b/"):
        current_file = line[6:]
    elif line.startswith("@@"):
        parts = line.split("+")
        if len(parts) > 1:
            current_line = int(parts[1].split(",")[0])
    elif line.startswith("+") and not line.startswith("++"):
        lines.append(f"File: {current_file}, Line: {current_line} - {line[1:]}")
        current_line += 1

if not lines:
    print("Nenhuma linha adicionada.")
    exit(0)

print("📄 Linhas adicionadas:")
print("\n".join(lines))

# Envia para IA local
prompt = (
    "Você é um revisor de código. Analise as linhas abaixo como um bloco de código completo, "
    "especialmente métodos ou funções.\n\n"
    "Aponte apenas onde há um erro real ou potencial, como retorno incorreto, tipo incompatível, "
    "uso indevido de linguagem ou lógica errada.\n\n"
    "Para cada erro, responda com:\nFile: NOME_DO_ARQUIVO, Line: NÚMERO - Descrição clara do problema.\n\n"
    "Se não houver erro, diga apenas: Nenhum problema encontrado.\n\n"
    "Linhas analisadas:\n" + "\n".join(lines)
)

data = {
    "model": "gemma3:1b",
    "prompt": prompt,
    "stream": False
}

print("🤖 Enviando para a IA local...")
response = subprocess.check_output(
    ['curl', '-s', 'http://host.docker.internal:11434/api/generate', '-d', json.dumps(data)],
    text=True
)

parsed = json.loads(response)
print("\n🧠 Resposta da IA:")
print(parsed.get("response", "Sem resposta"))
