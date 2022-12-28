import HttpClient from '../index'

class ApplicationApi extends HttpClient {
    list(page = 1, query) {
        return this.requestType('get').request(`/applications?page=${page}&${query}`)
    }

    lastDay() {
        return this.requestType('get').request(`/application/lastDay`)
    }

    get(slug) {
        return this.requestType('get').request(`/applications/${slug}/edit`)
    }

    update(id) {
        return this.requestType('post').request(`applications/update/${id}`)
    }
}

const applicationApi = new ApplicationApi()
export default applicationApi
