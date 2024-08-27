document.addEventListener('DOMContentLoaded', () => {
    let sortState = {
        name: 'none',
        description: 'none',
        time: 'none'
    };

    const edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener('click', (e) => {
            const display = e.target.closest('.display');
            if (display) {
                const title = display.getElementsByTagName('h2')[0].textContent.trim();
                const desc = display.getElementsByTagName('p')[0].textContent.trim();
                snoedit.value = e.target.id;
                titleedit.value = title;
                descedit.value = desc;
            }
        });
    });

    const deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener('click', (e) => {
            const display = e.target.closest('.display');
            if (display) {
                sno = e.target.id.substr(1);
                if (confirm("delete this note")) {
                    console.log("yes here")
                    window.location = `/todo_list/index.php?delete=${sno}`;
                }
            }
        });
    });

    // Adding sorting functionality
    document.getElementById('sort-name').addEventListener('click', () => {
        toggleSort('name', 'h2');
    });

    document.getElementById('sort-description').addEventListener('click', () => {
        toggleSort('description', 'p');
    });

    document.getElementById('sort-time').addEventListener('click', () => {
        toggleSort('time', 'p.time');
    });

    function toggleSort(key, selector) {
        const notesContainer = document.getElementById('notes-container');
        const notes = Array.from(notesContainer.getElementsByClassName('display'));

        // Determine sort direction
        const currentState = sortState[key];
        const newState = currentState === 'asc' ? 'desc' : 'asc';
        sortState[key] = newState;

        // Clear other sort indicators and reset arrows
        for (let k in sortState) {
            if (k !== key) {
                sortState[k] = 'none';
                document.getElementById(`sort-${k}`).innerHTML = capitalizeFirstLetter(k) + ' ↕';
                document.getElementById(`sort-${k}`).classList.remove('active-sort'); // Remove orange color from other buttons
            }
        }

        // Sort notes
        notes.sort((a, b) => {
            const aValue = a.querySelector(selector).textContent.trim();
            const bValue = b.querySelector(selector).textContent.trim();

            let comparison;
            if (selector === 'p.time') { // Sorting by date and time
                comparison = new Date(aValue).getTime() - new Date(bValue).getTime();
            } else {
                comparison = aValue.localeCompare(bValue);
            }

            return newState === 'asc' ? comparison : -comparison;
        });

        // Update sort indicator
        const arrow = newState === 'asc' ? '↑' : '↓';
        const sortButton = document.getElementById(`sort-${key}`);
        sortButton.innerHTML = capitalizeFirstLetter(key) + ` ${arrow}`;
        sortButton.classList.add('active-sort'); // Set the clicked button to orange

        // Reorder notes in the container
        notes.forEach(note => notesContainer.appendChild(note));
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Adding search functionality
    document.getElementById('search-button').addEventListener('click', () => {
        searchNotes();
    });

    document.getElementById('search-input').addEventListener('input', () => {
        searchNotes();
    });

    function searchNotes() {
        const query = document.getElementById('search-input').value.toLowerCase();
        const notesContainer = document.getElementById('notes-container');
        const notes = Array.from(notesContainer.getElementsByClassName('display'));

        notes.forEach(note => {
            const title = note.querySelector('h2').textContent.toLowerCase();
            const description = note.querySelector('p').textContent.toLowerCase();
            const time = note.querySelector('p.time').textContent.toLowerCase();

            if (title.includes(query) || description.includes(query) || time.includes(query)) {
                note.style.display = ''; // Show note
            } else {
                note.style.display = 'none'; // Hide note
            }
        });
    }

   




});
