// Import de pacotes
import React, { useCallback, useEffect, useRef, useState } from 'react';
import { Alert, Image, ImageBackground, Modal, ScrollView, StyleSheet, TouchableNativeFeedback, TouchableOpacity, TouchableWithoutFeedback, View } from 'react-native';
import { TextInputMask } from 'react-native-masked-text';
import { IconButton, RadioButton, Text, Title, TouchableRipple } from 'react-native-paper';
import { FontAwesome5 } from '@expo/vector-icons';
import { ParamListBase } from '@react-navigation/native';
import * as ImagePicker from 'expo-image-picker';
import { StackScreenProps } from '@react-navigation/stack';

// Import de páginas
import TextInput from '../../components/Input';
import Container, { ContainerTop } from '../../components/Container';
import request from '../../util/request';
import theme from '../../global/styles/theme';
import { Button } from '../../components/Button';
import { ButtonClose, ButtonSelect, ContentModal, ViewModal } from '../../components/GlobalCSS';
import api from '../../services/api';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function AddServices({ navigation }: StackScreenProps<ParamListBase>) {
    // Variáveis

    // RadioButtons selecionados
    const [category, setCategory] = useState();
    const [subCategoriasSelect, setSubCategoriasSelect] = useState();

    const [comentario, setComentario] = useState('');
    const [loading, setLoading] = useState(false);

    const [categorias, setCategorias] = useState([]);
    const [subCategorias, setSubCategorias] = useState([]);
    const [price, setPrice] = useState('');

    const selectCategory = useCallback((id) => {

        setCategory(id);
        const filterCategories = subCategorias.filter((sub) => {
            return sub.category_id === Number(id);
        });

        console.log(filterCategories);
    }, [subCategorias]);

    const setAllCategories = async () => {
        try {
            const response = await api.get('category');
            setCategorias(response.data);

            const response2 = await api.get('subcategory');
            setSubCategorias(response2.data);

        } catch (e) { console.log(e.response.data.message); }
    }

    useEffect(() => {
        setAllCategories();
    }, []);

    const submit = async () => {
        try {
            const response = await api.post('user/subcategory', {
                subcategory_id: subCategoriasSelect,
                price: price.replace('R$', '').replace(',', '.')
            });

            setCategory(0); setSubCategoriasSelect(0); setPrice(0);
            console.log('PRODUTO: %s', response.data);
            Alert.alert('AVISO', 'Serviço cadastrado com sucesso', [{
                text: 'OK',
                onPress: () => { },
            }], { cancelable: true });
        } catch (e) { console.log('ERROR: ' + e.response.data.message); }
    }

    // Construção da página
    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        // height: 160,
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Container
                        pb
                        // padding={30}
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}>
                        <Image
                            source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }} />
                        <TouchableOpacity
                            onPress={() => navigation.goBack()}
                            style={{
                                position: 'absolute',
                                alignSelf: 'flex-start',
                                marginLeft: '5%',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start',
                            }}>
                            <FontAwesome5
                                name='chevron-left'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                        <Text style={styles.textStyleF}>
                            RoboComp - Cadastrar Serviços
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <ScrollView style={styles.scrollView}>
                <Container pb />
                <Container horizontal pt>
                    {/* <View>
                        <Text
                            style={{
                                marginBottom: 7,
                                marginRight: 10,
                                fontSize: 20,
                                fontFamily: theme.fonts.bold,
                                width: '90%',
                            }}>
                            Adicionar fotos ao serviço:
                        </Text>
                    </View> */}
                    {/* <Photos
                    photos={transformToPhotoArray(photos)}
                    addPhoto={uri => setPhotos([...photos, uri])}
                    removeImage={index => {
                    setPhotos(p => [...p.slice(0, index), ...p.slice(index + 1)]);
                    }}
                /> */}
                </Container>
                <Text style={styles.title}>Categoria:</Text>

                {/* Categorias cadastradas do usuário */}
                <Container>
                    <Container style={styles.radioGroup}>
                        {(categorias.length > 0) && categorias.map(cate => (
                            <TouchableOpacity key={cate.id} style={styles.radio} onPress={() => { selectCategory(cate.id) }}>
                                <RadioButton
                                    key={cate.id}
                                    value={cate.id}
                                    status={(category === cate.id) ? 'checked' : 'unchecked'}
                                    onPress={() => { selectCategory(cate.id) }} />
                                <View style={{ width: 30, height: 30, marginRight: 5 }}>
                                    <Image
                                        source={{ uri: cate.icon_url }}
                                        style={{ width: 30, height: 30 }}
                                    />
                                </View>
                                <Text>{cate.name}</Text>
                            </TouchableOpacity>
                        ))}
                    </Container>
                    <Text style={styles.title2}>Serviço oferecido:</Text>

                    {/* Subcategorias cadastradas para o usuário */}
                    {(category === '') ? <View /> :
                        <>
                            {
                                subCategorias.map(sub => (
                                    (sub.category_id !== category) ? <View /> :
                                        <>
                                            <View style={{ flexDirection: 'row', alignItems: 'center', marginLeft: '5%' }}>
                                                <RadioButton
                                                    key={sub.id}
                                                    value={sub.id}
                                                    status={(subCategoriasSelect === sub.id) ? 'checked' : 'unchecked'}
                                                    onPress={() => { setSubCategoriasSelect(sub.id) }} />
                                                <Text>{sub.name}</Text>
                                            </View>
                                            {(subCategoriasSelect) ?
                                                <>
                                                    <Text style={styles.title}>Preço:</Text>
                                                    <TextInputMask
                                                        style={styles.inputMask}
                                                        type='money'
                                                        options={{
                                                            precision: 2,
                                                            separator: ',',
                                                            delimiter: '.',
                                                            unit: 'R$',
                                                            suffixUnit: ''
                                                        }}
                                                        value={price}
                                                        editable={true}
                                                        onChangeText={value => setPrice(value)}
                                                    />
                                                </>
                                                : <View />}
                                        </>
                                ))
                            }
                        </>
                    }
                    <>
                        <Container horizontal vertical>
                            <Button
                                onPress={submit} //submit para funcionar
                                text="SALVAR SERVIÇO"
                                fullWidth
                                loading={loading}
                                backgroundColor={theme.colors.newcolor}
                            />
                        </Container>
                    </>
                    {/* :<View /> */}
                    {/* )))} */}
                </Container>
            </ScrollView>
        </>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        backgroundColor: theme.colors.gray,
        marginHorizontal: 0,

    },
    textStyle: {
        fontSize: 20,
        fontFamily: theme.fonts.bold,
        color: 'white',
        textAlign: 'center',
    },

    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    title: {
        fontSize: 16,
        paddingLeft: '4%',
        paddingTop: '4%',
        marginBottom: -10
    },
    title2: {
        fontSize: 16,
        paddingLeft: '4%',
        paddingTop: '4%',
        marginBottom: 10
    },
    inputMask: {
        marginLeft: '3%',
        marginVertical: '3%',
        width: '25%',
        height: 40,
        borderWidth: 1,
        borderColor: theme.colors.black,
        backgroundColor: '#fff',
        alignItems: 'center',
        textAlign: 'center',
    },
    radio: {
        margin: 10,
        flexDirection: 'row',
        alignItems: 'center',
        minWidth: '39%',
    },
    radioGroup: {
        width: '90%',
        margin: 15,
        flexDirection: 'row',
        flexWrap: 'wrap',
    },
    radio2: {
        marginHorizontal: 10,
        marginVertical: '-1%',
        flexDirection: 'row',
        alignItems: 'center',
        minWidth: '39%',
    },
    radioGroup2: {
        width: '70%',
        marginHorizontal: 15,
        flexDirection: 'row',
        flexWrap: 'wrap',
    },
});