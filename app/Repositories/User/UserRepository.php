<?php


namespace App\Repositories\User;


use App\Enums\FileDirectory;
use App\Models\AboutMe;
use App\Models\Information;
use App\Models\User;
use App\Services\FileUpload;
use DB;
use Illuminate\Http\Request;
use Throwable;

class UserRepository implements UserInterface
{
    /**
     * @param $request
     * @return array
     */

    private function getProfileDataFromRequest($request): array
    {
        return $request->only([
            'name',
            'email',
            'image',
        ]);
    }

    public function updateProfile($user, Request $request)
    {
        try {
            DB::beginTransaction();

            $gender = '';
            if ($request->input('gender') == 1) {
                $gender = 'female';
            } else {
                $gender = 'm';
            }

            if ($request->input('locale') == 'en') {
                $user = User::where('id', $user->id)->update([
                    'first_name_en' => $request->input('first_name'),
                    'last_name_en' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'gender' => $gender,
                    'bio_en' => $request->input('bio'),
                    'types_en' => $request->input('types'),
                ]);
            } else {
                $user = User::where('id', $user->id)->update([
                    'first_name_bn' => $request->input('first_name'),
                    'last_name_bn' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'gender' => $gender,
                    'bio_bn' => $request->input('bio'),
                    'types_bn' => $request->input('types'),
                ]);
            }


            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();

            return $e;
        }
    }

    public function updateProfileAndImage($user, Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $files = (new FileUpload($request->file('image')))
                    ->directory(FileDirectory::AVATAR . $user->id)
                    ->setDimension(null, null)
                    ->setFileName($request->file('image')->getClientOriginalName())
                    ->upload();
            }

//            Information::where('key', 'user_image')->update(['value' => FileDirectory::AVATAR . $user->id . '/' . $request->file('image')->getClientOriginalName()]);
            $gender = '';
            if ($request->input('gender') == 1) {
                $gender = 'female';
            } else {
                $gender = 'm';
            }

            if ($request->input('locale') == 'en') {
                $user = User::where('id', $user->id)->update([
                    'first_name_en' => $request->input('first_name'),
                    'last_name_en' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'gender' => $gender,
                    'bio_en' => $request->input('bio'),
                    'image' => FileDirectory::AVATAR . $user->id . '/' . $request->file('image')->getClientOriginalName(),
                    'types_en' => $request->input('types'),
                ]);
            } else {
                $user = User::where('id', $user->id)->update([
                    'first_name_bn' => $request->input('first_name'),
                    'last_name_bn' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'gender' => $gender,
                    'image' => FileDirectory::AVATAR . $user->id . '/' . $request->file('image')->getClientOriginalName(),
                    'bio_bn' => $request->input('bio'),
                    'types_bn' => $request->input('types'),
                ]);
            }

            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();

            return $e;
        }
    }

    public function updatePassword($userId)
    {
        // TODO: Implement updatePassword() method.
    }

    public function emailUpdate($userId)
    {
        // TODO: Implement emailUpdate() method.
    }

    public function emailVerification($email)
    {
        // TODO: Implement emailVerification() method.
    }

    public function tokenVerification($email)
    {
        // TODO: Implement tokenVerification() method.
    }


}
