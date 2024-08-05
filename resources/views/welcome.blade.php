<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Characters List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold my-4">Characters List</h1>
        <input
            type="text"
            id="search-input"
            placeholder="Search characters..."
            class="mb-4 p-2 border border-gray-300 rounded-lg w-full"
        />
        <div id="characters-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
    </div>

    <!-- Modal HTML -->
    <div id="character-modal" class="modal">
        <div id="modal-content" class="modal-content">
            <span id="close-modal" class="float-right text-xl font-bold cursor-pointer">&times;</span>
            <h2 id="modal-name" class="text-2xl font-bold mb-4"></h2>
            <p><strong>Race:</strong> <span id="modal-race"></span></p>
            <p><strong>Birth:</strong> <span id="modal-birth"></span></p>
            <p><strong>Gender:</strong> <span id="modal-gender"></span></p>
            <p><strong>Death:</strong> <span id="modal-death"></span></p>
            <p><strong>Height:</strong> <span id="modal-height"></span></p>
            <p><strong>Realm:</strong> <span id="modal-realm"></span></p>
            <p><strong>Spouse:</strong> <span id="modal-spouse"></span></p>
            <a id="modal-wikiUrl" href="#" target="_blank" class="text-blue-500">Wiki Link</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const charactersList = document.getElementById('characters-list');
            const modal = document.getElementById('character-modal');
            const modalContent = document.getElementById('modal-content');
            const closeModal = document.getElementById('close-modal');

            let characters = []; // To store all characters

            function fetchCharacters() {
                fetch('/all-characters')
                    .then(response => response.json())
                    .then(data => {
                        characters = data.docs; // Store the fetched characters
                        displayCharacters(characters); // Display all characters initially
                    })
                    .catch(error => {
                        console.error('Error fetching characters:', error);
                    });
            }

            function displayCharacters(charactersToDisplay) {
                charactersList.innerHTML = '';
                charactersToDisplay.forEach(character => {
                    const characterBox = document.createElement('div');
                    characterBox.classList.add('bg-white', 'p-4', 'rounded-lg', 'shadow-md', 'space-y-2', 'cursor-pointer');
                    characterBox.dataset.character = JSON.stringify(character); // Store character data

                    const name = document.createElement('h3');
                    name.classList.add('text-xl', 'font-semibold');
                    name.textContent = character.name;

                    characterBox.appendChild(name);

                    charactersList.appendChild(characterBox);
                });

                // Add click event listeners to each character box
                document.querySelectorAll('.cursor-pointer').forEach(box => {
                    box.addEventListener('click', function() {
                        const character = JSON.parse(this.dataset.character);
                        showModal(character);
                    });
                });
            }

            function filterCharacters(query) {
                const filteredCharacters = characters.filter(character =>
                    character.name.toLowerCase().includes(query.toLowerCase())
                );
                displayCharacters(filteredCharacters);
            }

            function showModal(character) {
                document.getElementById('modal-name').textContent = character.name;
                document.getElementById('modal-race').textContent = character.race || 'N/A';
                document.getElementById('modal-birth').textContent = character.birth || 'N/A';
                document.getElementById('modal-gender').textContent = character.gender || 'N/A';
                document.getElementById('modal-death').textContent = character.death || 'N/A';
                document.getElementById('modal-height').textContent = character.height || 'N/A';
                document.getElementById('modal-realm').textContent = character.realm || 'N/A';
                document.getElementById('modal-spouse').textContent = character.spouse || 'N/A';
                document.getElementById('modal-wikiUrl').href = character.wikiUrl || '#';

                modal.style.display = 'block';
            }

            function closeModalHandler() {
                modal.style.display = 'none';
            }

            searchInput.addEventListener('input', function() {
                const query = searchInput.value;
                filterCharacters(query);
            });

            closeModal.addEventListener('click', closeModalHandler);

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModalHandler();
                }
            });

            // Initial fetch
            fetchCharacters();
        });
    </script>
</body>
</html>
