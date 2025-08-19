<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    /**
     * List submissions for a specific form.
     */
    public function index(Form $form)
    {
        $submissions = $form->submissions()->latest()->paginate(20);

        return view('admin.forms.submissions.index', compact('form', 'submissions'));
    }

    /**
     * Show a single submission.
     */
    public function show(Form $form, FormSubmission $submission)
    {
        return view('admin.forms.submissions.show', compact('form', 'submission'));
    }

    /**
     * Delete a submission.
     */
    public function destroy(Form $form, FormSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.forms.submissions.index', $form)
            ->with('success', 'Submission deleted successfully.');
    }
}
