
export function searchTrophy() {
    return `
        <img src="../IMG/trophy.png" alt="Trophy" style="display: inline-block;" width="15px" height="15px">
    `;
}

export function createTableShow(data) {
    let tableRows = '';

    // Para facilitar as iterações, transformar o valores de datas em array
    const dataValues = Object.values(data);
    for (let i = 0; i < dataValues.length; i++) {
        const line = dataValues[i];
        let numbersCells = '';
        
        // Criar devidamente as colunas que conterão os cinco números
        for (let j = 0; j < line.numbers.length; j++) {
            numbersCells += `<td class="column">${line.numbers[j]}</td>`;
        }

        let row = `
            <tr>
                <td class="column">${line.registration_nr}</td>
                <td class="column">${line.name}</td>
                <td class="column">${line.cpf}</td>
                ${numbersCells}
            </tr>
        `;
        tableRows += row;
    }

    return tableRows;
}