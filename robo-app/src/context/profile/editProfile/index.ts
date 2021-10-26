import { createStateLink } from '@hookstate/core';
import Profile from '../../../interfaces/Profile';
import request from '../../../util/request';
import Request from '../../../interfaces/Request';
import notify from '../../../util/notify';

const stateRef = createStateLink<Omit<Profile, 'cpf'>>({
    address: '',
    cep: '',
    city: '',
    complement: '',
    district: '',
    email: '',
    name: '',
    number: '',
    phone: '',
    state: '',
});

const editableProfileRef = stateRef.wrap((s) => ({
    set: (profile: Profile) => s.set(profile),
    setAddress: (address: string) => s.set({ ...s.value, address }),
    setCep: (cep: string) => s.set({ ...s.value, cep }),
    setCity: (city: string) => s.set({ ...s.value, city }),
    setComplement: (complement: string) => s.set({ ...s.value, complement }),
    setDistrict: (district: string) => s.set({ ...s.value, district }),
    setEmail: (email: string) => s.set({ ...s.value, email }),
    setName: (name: string) => s.set({ ...s.value, name }),
    setNumber: (number: string) => s.set({ ...s.value, number }),
    setPhone: (phone: string) => s.set({ ...s.value, phone }),
    setState: (state: string) => s.set({ ...s.value, state }),
    state: s.value,
}));
const submittingProfileRef = createStateLink(false);
const submitProfile = async () => {
    const submitting = submittingProfileRef.access();
    const editableProfile = editableProfileRef.access();
    submitting.set(true);
    const {
        name,
        number,
        address,
        phone,
        district,
        city,
        state,
        cep,
        complement,
    } = editableProfile.state;
    const response = await request.authPost<Request<string>>('Clients/updateClient', {
        name,
        number_contact: phone,
        address,
        number,
        district: district ?? '',
        city,
        state,
        cep,
        complement: complement ?? '',
    });
    if (response.status === true) {
        notify('Salvo com sucesso!', 'success');
    } else {
        notify(response.result.message, 'error');
    }
    submitting.set(false);
};

export default {
    editableProfileRef,
    submittingProfileRef,
    submitProfile,
};
