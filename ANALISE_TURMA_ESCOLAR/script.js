function adicionarAlunos() {
    var quantidade = document.getElementById("quantidade").value;
    var alunos = document.getElementById("alunos");

    alunos.innerHTML = "";

    for (var i = 1; i <= quantidade; i++) {
        alunos.innerHTML += `    
            <div class="aluno">
                <h3>Aluno ${i}</h3>

                <label>Nome do Aluno:</label>
                <input type="text" name="nome[]" required>

                <label>Nota da Prova 1:</label>
                <input type="number" name="nota1[]" step="0.1" min="0" max="10" required>
                
                <label>Nota da Prova 2:</label>
                <input type="number" name="nota2[]" step="0.1" min="0" max="10" required>

                <label>Nota de Trabalho:</label>
                <input type="number" name="trabalho[]" step="0.1" min="0" max="10" required>               
            </div>
        `;
    }
}