import HttpClientBase from "../../_common/classes/HttpClientBase";

export default class Users extends HttpClientBase
{
    async register(data) {
        return this.post("/users/register", data);
    }
}