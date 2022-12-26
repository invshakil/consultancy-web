import HttpClient from '../index'

class ApplicationApi extends HttpClient {
    list(page = 1, query) {
        return this.requestType('get').request(`/applications?page=${page}&${query}`)
    }

    get(slug) {
        return this.requestType('get').request(`/articles/${slug}/edit`)
    }

    delete(id) {
        return this.requestType('delete').request(`articles/${id}`)
    }
}

const applicationApi = new ApplicationApi()
export default applicationApi
