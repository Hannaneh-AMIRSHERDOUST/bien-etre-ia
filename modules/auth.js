// auth.js - Module d'authentification Omeka S
export class auth {
    constructor(params) {
        this.api = params.api;
        this.identity = params.identity;
        this.credential = params.credential;
        this.mail = params.mail;
    }

    getUser(callback) {
        fetch(`${this.api}users?email=${this.mail}`, {
            headers: {
                'Authorization': 'Basic ' + btoa(`${this.identity}:${this.credential}`)
            }
        })
        .then(response => response.json())
        .then(data => callback(data[0]))
        .catch(error => console.error('Erreur:', error));
    }

    createItem(data, callback) {
        fetch(`${this.api}items`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Basic ' + btoa(`${this.identity}:${this.credential}`)
            },
            body: JSON.stringify(this.formatItemData(data))
        })
        .then(response => response.json())
        .then(result => callback(result))
        .catch(error => console.error('Erreur:', error));
    }

    formatItemData(data) {
        let formatted = {};
        
        // Resource class
        if (data['o:resource_class']) {
            formatted['o:resource_class'] = { 'o:id': this.getClassId(data['o:resource_class']) };
        }
        
        // Resource template
        if (data['o:resource_template']) {
            formatted['o:resource_template'] = { 'o:id': data['o:resource_template'] };
        }
        
        // Properties - convert simple values to Omeka format
        for (let key in data) {
            if (key.includes(':') && !key.startsWith('o:')) {
                formatted[key] = [{ '@value': data[key] }];
            }
        }
        
        return formatted;
    }

    getClassId(className) {
        // Map class names to IDs (adjust based on your Omeka installation)
        const classMap = {
            'dctype:Event': 42,
            'beo:Exercise': 8
        };
        return classMap[className] || className;
    }
}
