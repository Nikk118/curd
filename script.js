
    // Get all elements with the class name 'edit'
    document.addEventListener('DOMContentLoaded', () => {
        const edits = document.getElementsByClassName('edit');

        Array.from(edits).forEach((element) => {
            element.addEventListener('click', (e) => {
                const display = e.target.closest('.display');
                console.log(display)

                if (display) {
                    const title = display.getElementsByTagName('h2')[0].textContent.trim();
                    console.log(title)
                    const desc = display.getElementsByTagName('p')[0].textContent.trim();
                    console.log(desc)
                    snoedit.value=e.target.id;
                    console.log(e.target.id)
                    titleedit.value=title;
                    descedit.value=desc;

                    
                }
            });
        });
        const deletes = document.getElementsByClassName('delete');

        Array.from(deletes).forEach((element) => {
            element.addEventListener('click', (e) => {
              console.log("click")
                const display = e.target.closest('.display');
                console.log(display)

                if (display) {
                    sno = e.target.id.substr(1, )
                    console.log(sno)
                    // Update the modal fields with the current note's data
                    if (confirm("delete this node")) {
                        console.log("yes")
                        window.location = `/curd/index.php?delete=${sno}`;
                    } else {
                        console.log("no")

                    }
                }
            });
        });

    });
    