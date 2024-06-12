describe('Formulaire de Connexion', () => {
    it('test 1 - connexion OK', () => {
        cy.visit('http://127.0.0.1:8001/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('test@gmail.com', {force: true});
        cy.get('#password').type('password123', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]', {force: true}).click({force: true});

        // Vérifier que l'utilisateur est connecté
        cy.contains('Un URL sufit dans sublime pour obtenir un super PDF').should('exist');
    });

    it('test 2 - connexion KO', () => {
        cy.visit('http://127.0.0.1:8001/login');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#username').type('wrongemail@email.com', {force: true});
        cy.get('#password').type('wrongpassword', {force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click({force: true});

        // Vérifier que le message d'erreur est affiché
        cy.contains('Invalid credentials.').should('exist');
    });
});