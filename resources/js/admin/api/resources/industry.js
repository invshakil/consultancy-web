import HttpClient from '../index'

class IndustryApi extends HttpClient {

    getIndustries(page = 1) {
        return this.requestType('get').request(`/industries?page=${page}`)
    }

    getIndustryDetails(id) {
        return this.requestType('get').request(`/industries/${id}`)
    }

    save(payload) {
        return this.requestType('post').formBody(payload).request(`industries`)
    }

    update(payload, id) {
        return this.requestType('patch').formBody(payload).request(`industries/${id}`)
    }

    delete(id) {
        return this.requestType('delete').request(`industries/${id}`)
    }
}

const industryApi = new IndustryApi()
export default industryApi
