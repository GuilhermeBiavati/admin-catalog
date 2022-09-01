import Keycloak from "keycloak-js";

const keycloakCrendials = JSON.parse(process.env.REACT_APP_KEYCLOAK_JSON!);

export const keycloak = Keycloak({
    url : keycloakCrendials['auth-server-url'],
    realm: keycloakCrendials['realm'],
    clientId: keycloakCrendials['resource'],
});