describe('Formulaire d inscription', () => {
    it('test 1 - inscription ok', () => {
        cy.visit('http://127.0.0.1:8001/register');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#registration_form_email').type('test@gmail.com', {force: true});
        cy.get('#registration_form_plainPassword').type('password123', {force: true});
        cy.get('#registration_form_agreeTerms').click({force: true});

        // Soumettre le formulaire
        cy.get('button[type="submit"]', {force: true}).click({force: true});

        // Vérifier que l'utilisateur est connecté
        cy.contains('Un URL sufit dans sublime pour obtenir un super PDF').should('exist');
    });
});