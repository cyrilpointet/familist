export class User {
    constructor(props) {
        this.id = props.id;
        this.name = props.name;
        this.email = props.email;
        this.created_at = props.created_at;
        this.todolists = props.todolists.map((list) => {
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
