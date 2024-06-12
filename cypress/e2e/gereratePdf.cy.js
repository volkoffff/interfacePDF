describe('Formulaire de génération de pdf', () => {

    it('test 1 - ok génération avec https://', () => {

        // connect to the app
        cy.visit('http://127.0.0.1:8001/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('test@gmail.com', {force: true});
        cy.get('#password').type('password123', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]', {force: true}).click({force: true});

        // Vérifier que l'utilisateur est connecté
        cy.contains('Un URL sufit dans sublime pour obtenir un super PDF').should('exist');
        // end of connection

        cy.visit('http://127.0.0.1:8001/generate_pdf');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#pdf_form_url').type('https://www.google.com', {force: true});
        cy.get('#pdf_form_title').type('google test 1', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]', {force: true}).click({force: true});

        // Vérifier que l'utilisateur est connecté
        cy.contains('Voir l\'historique des téléchargements').should('exist');
    });

    it('test 2 - ok génération sans https://', () => {

        // connect to the app
        cy.visit('http://127.0.0.1:8001/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('test@gmail.com', {force: true});
        cy.get('#password').type('password123', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]', {force: true}).click({force: true});

        // Vérifier que l'utilisateur est connecté
        cy.contains('Un URL sufit dans sublime pour obtenir un super PDF').should('exist');
        // end of connection

        cy.visit('http://127.0.0.1:8001/generate_pdf');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#pdf_form_url').type('www.google.com', {force: true});
        cy.get('#pdf_form_title').type('google test 2', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click({force: true});

        // Vérifier que le message d'erreur est affiché
        cy.contains('Voir l\'historique des téléchargements').should('exist');
    });

    it('test 3 - ko génération fail link', () => {

        // connect to the app
        cy.visit('http://127.0.0.1:8001/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('test@gmail.com', {force: true});
        cy.get('#password').type('password123', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]', {force: true}).click({force: true});

        // Vérifier que l'utilisateur est connecté
        cy.contains('Un URL sufit dans sublime pour obtenir un super PDF').should('exist');
        // end of connection

        cy.visit('http://127.0.0.1:8001/generate_pdf');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#pdf_form_url').type('google', {force: true});
        cy.get('#pdf_form_title').type('google test 3', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click({force: true});

        // Vérifier que le message d'erreur est affiché
        cy.contains('Svp entrer une URL valide. Exemple: https://www.google.com').should('exist');
    });
});