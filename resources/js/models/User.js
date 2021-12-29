export class User {
    constructor(rawUser) {
        this.id = rawUser.id;
        this.name = rawUser.name;
        this.email = rawUser.email;
        this.created_at = rawUser.created_at;
        this.todolists = rawUser.todolists.map((list) => {
            return {
                id: list.id,
                name: list.name,
                createdAt: new Date(list.created_at).toLocaleDateString(
                    "fr-FR"
                ),
            };
        });
    }

    get createdAt() {
        const createdAt = new Date(this.created_at);
        return createdAt.toLocaleDateString("fr-FR");
    }
}
