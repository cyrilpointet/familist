export class Todolist {
    constructor(props) {
        this.id = props.id;
        this.name = props.name;
        this.created_at = props.created_at;
        this.users = props.users.map((user) => {
            return {
                id: user.id,
                name: user.name,
                email: user.email,
            };
        });
    }

    get createdAt() {
        const createdAt = new Date(this.created_at);
        return createdAt.toLocaleDateString("fr-FR");
    }
}
